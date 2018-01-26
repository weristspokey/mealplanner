<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\GrocerylistItem;
use App\Entity\Food;
use App\Entity\Grocerylist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class GrocerylistItemType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // ->add('grocerylistId', EntityType::class, [
        //         'class'         => Grocerylist::class,
        //         'choice_label'  => 'name',
        //         'label' => false,
        //         'required' => true,
        //         'attr' => [
        //             'class' => 'd-none',
        //             'data-live-search' => 'true'
        //         ],
        //         ]
        //     )
        ->add('foodId', EntityType::class, [
                'class'         => Food::class,
                'choice_label'  => 'name',
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => 'true'
                ],
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
            'data_class' => GrocerylistItem::class

        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_grocerylistItem';
    }


}
