<?php

namespace AppBundle\Form;

use AppBundle\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;


class RecipeType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();
            if (!$user) 
            {
                throw new \LogicException(
                    'The RecipeFormType cannot be used without an authenticated user!'
                );
            }
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                'placeholder' => 'Name of the Recipe']]
            )
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                'placeholder' => 'Description',
                'rows' => '9']]
            )
            ->add('tags', EntityType::class, [
                'class'         => Tag::class,
                'choice_label'  => 'name',
                'label' => false,
                'required' => true,
                'placeholder' => 'Tags',
                'multiple' => true,
                'query_builder' => function(EntityRepository $er) use ($user)
                {
                    return $er->createQueryBuilder('tag')
                    ->where('tag.userId ='.  $user->getId())
                    ->orderBy('tag.name', 'ASC');
                },
                'attr' => [
                    'class' => 'selectpicker']
                ]
            )
            // ->add('recipeItems', TextType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'attr' => [
            //     'placeholder' => 'Ingredients']]
            // )
            ->add('image', FileType::class, [
                'label' => false,
                'required' => false,
                 'data_class' => null,
                'attr' => [
                'placeholder' => 'an image for your recipe']]
            )
            ->add('Submit', SubmitType::class);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Recipe::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recipe';
    }


}
