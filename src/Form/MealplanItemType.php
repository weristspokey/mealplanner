<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Food;
use App\Entity\Mealplan;
use App\Entity\MealplanItem;
use App\Entity\Recipe;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MealplanItemType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add('mealplanId', EntityType::class, [
        //         'class'         => Mealplan::class,
        //         'choice_label'  => 'id',
        //         'label' => false,
        //         'required' => true,
        //         'attr' => [
        //             //'class' => 'd-none',
        //             'data-live-search' => 'true'
        //         ],]
        //     )
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
                ]
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
        return 'app_mealplanItem';
    }


}
