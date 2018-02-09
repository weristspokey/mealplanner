<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Form\RecipeItemType;
use App\Form\TagSelectpickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Food;
use App\Entity\RecipeItem;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\Repository\TagRepository;

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
            ->add('tags', EntityType::class, array(
                'class' => Tag::class,
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Tags',
                    'class' => 'selectpicker',
                    'multiple' => 'true'
                ],
                'query_builder' => function (TagRepository $repo) use ($user){
                    return $repo->showListsOfCurrentUser($user);
                    }
            ))
            ->add('image', FileType::class, [
                'label' => false,
                'required' => false,
                 'data_class' => null,
                'attr' => [
                'placeholder' => 'an image for your recipe']]
            )
            ->add('Submit', SubmitType::class);
        // $builder->get('tags')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($tagsAsArray) {
        //             return implode(',', $tagsAsArray);
        //         },
        //         function ($tagsAsString) {
        //             return explode(',', $tagsAsString);
        //         }
        //     ));

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
        return 'app_recipe';
    }


}
