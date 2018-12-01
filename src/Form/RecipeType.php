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
                    'placeholder' => 'Name of the Recipe',
                    'autofocus' => true
                    ]
                ]

            )
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                'placeholder' => 'Description',
                'rows' => '9']]
            )
            ->add('tags', TextType::class, array(
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Tags',
                    'class' => 'col-md-6 d-none',
                    'multiple' => true
                ]
            ))
            ->add('image', FileType::class, [
                'label' => false,
                'required' => false,
                 'data_class' => null,
                 'empty_data' => null,
                  'help' => 'The ZIP/Postal code for your credit card\'s billing address.',
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
        return 'app_recipe';
    }


}
