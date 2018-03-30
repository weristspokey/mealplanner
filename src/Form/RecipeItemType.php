<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
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


class RecipeItemType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', NumberType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                'placeholder' => 'Value',
                ]]
            )
            ->add('unit', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices'  => array(
                    'ml' => 'ml',
                    'mg' => 'mg',
                    'l'  => 'l',
                    'Stück' => 'Stück'
                )]
            )
            ->add('foodId', EntityType::class, [
                'class'         => Food::class,
                'choice_label'  => 'name',
                'label' => false,
                'required' => true
                ]
            );

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RecipeItem::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'RecipeItemType';
    }


}
