<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sale', ChoiceType::class, [
                'label' => 'Vente ou location',
                'choices' => [
                    'Vente' => 'vente',
                    'Location' => 'location'
                ]
            ])
            ->add('title', TextType::class, ['label' => 'Titre de l\'annonce'])
            ->add('mark', TextType::class, ['label' => 'Marque'])
            ->add('model', TextType::class, ['label' => 'Modèle'])
            ->add('fuelType', ChoiceType::class, [
                'label' => 'Type de carburant',
                'choices' => [
                    'Essence' => 'essence',
                    'Diesel' => 'diesel',
                    'Electrique' => 'electrique',
                    'Hybride' => 'hybride',
                    'Gpl' => 'gpl'
                ]
            ])
            ->add('boxType', ChoiceType::class, [
                'label' => 'Boite de vitesse',
                'choices' => [
                    'Manuel' => 'manuel',
                    'Automatique' => 'automatique',
                    'Semi-automatique' => 'semi-automatique'
                ]
            ])
            ->add('year', DateType::class, [
                'label' => 'Date de mise en circulation',
                'format' => 'yMd',
                'widget' => 'choice',
                'years' => range(1920, date('Y'))
            ])
            ->add('kms', TextType::class, ['label' => 'Nombres de kilomètres'])
            ->add('price', TextType::class, ['label' => 'Prix'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('pictures', FileType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => true
            ])
            ->add('city', HiddenType::class, [
                'required' => false
            ])
            ->add('longitude', HiddenType::class, [
                'required' => false
            ])
            ->add('latitude', HiddenType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
