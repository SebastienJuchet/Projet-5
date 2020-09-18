<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre de l\'annonce'])
            ->add('mark', TextType::class, ['label' => 'Marque'])
            ->add('model', TextType::class, ['label' => 'Modèle'])
            ->add('fuelType', ChoiceType::class, [
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Electrique' => 'electrique',
                    'Hybride' => 'hybride',
                    'Gpl' => 'gpl'
                ]])
            ->add('boxType', ChoiceType::class, [
                'choices' => [
                    'Manuel' => 'manuel',
                    'Automatique' => 'automatique',
                    'Semi-automatique' => 'semi-automatique'
                ]])
            ->add('year', IntegerType::class, ['label' => 'Année de mise en circulation'])
            ->add('kms', IntegerType::class, ['label' => 'Nombres de kilomètres'])
            ->add('price', IntegerType::class, ['label' => 'Prix'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('image', TextType::class, [
                'label' => 'Image', 
                'required' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
