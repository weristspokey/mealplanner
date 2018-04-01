<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\RecipeItemCollection;

class RecipeItemCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recipeItemCollection', Type\CollectionType::class, [
            'entry_type'   => RecipeItemType::class,
            'label'        => false,
            'allow_add'    => true,
            'allow_delete' => true,
            'prototype'    => true,
            'required'     => false,
            'attr'         => [
                'class' => 'collection',
            ],
        ]);

        $builder->add('save', SubmitType::class, [
            'label' => 'Add item',
             'attr'         => [
                'class' => 'btn-default btn-sm',
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RecipeItemCollection::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'RecipeItemCollectionType';
    }
}