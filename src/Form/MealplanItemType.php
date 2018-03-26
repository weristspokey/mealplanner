<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Food;
use App\Entity\Mealplan;
use App\Entity\MealplanItem;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MealplanItemType extends AbstractType
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
                    'The MealplanItemFormType cannot be used without an authenticated user!'
                );
            }
        $builder
        ->add('mealplanId', DateType::class, [
            'widget' => 'single_text',
            'label' => false,
            'attr' => [
                    'class' => 'form-control',
                    'type' => 'date'
                ]
            ])
        ->add('category', ChoiceType::class, [
            'choices'  => [
                'Breakfast' => 'Breakfast',
                'Lunch' => 'Lunch',
                'Dinner' => 'Dinner',
                'Snacks' => 'Snacks'
                ],
            'label' => 'Choose Type',
            'attr' => [
                    'class' => 'selectpicker'
                ]
            ])
        ->add('foodId', EntityType::class, [
                'class'         => Food::class,
                'choice_label'  => 'name',
                'label' => 'Choose Food',
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker food-select',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-max-options' => '1'
                ]
                ]
        )
        ->add('recipeId', EntityType::class, [
                'class'         => Recipe::class,
                'choice_label'  => 'name',
                'label' => 'Choose Recipe',
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker recipe-select',
                    'multiple' => true,
                    'data-live-search' => true,
                    'data-max-options' => '1'
                ],
                'query_builder' => function (RecipeRepository $repo) {
                    $user = $this->tokenStorage->getToken()->getUser();
                    return $repo->showRecipesOfCurrentUser($user);
                    }
                ]
        )
        ->add('Submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MealplanItem::class

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'MealplanItem';
    }


}
