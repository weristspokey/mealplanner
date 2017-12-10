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
use AppBundle\Controller\RecipeController;


class RecipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            ->add('tags', ChoiceType::class, [
                'choices' => ['hi', 'ho', 'h'],
                'label' => false,
                'required' => false,
                'placeholder' => 'Tags',
                'multiple' => true,
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
