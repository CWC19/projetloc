<?php

namespace App\Form;

use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('model',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('puissance',NumberType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('carburant', ChoiceType::class, [
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Electrique' => 'Electrique',
                ],
                'expanded' => true, // Permet de rendre les cases à cocher au lieu d'un menu déroulant
                'label' => 'Carburant :', // Libellé du champ
                'required' => true, // Champ requis

                "attr"=>[
                    "class"=>"form-control"
                ], 
                
            ])
            ->add('boite_vitesse', ChoiceType::class, [
                'choices' => [
                    'Automatique' => 'Automatique',
                    'Manuelle' => 'Manuelle',
                ],
                'expanded' => true, // Permet de rendre les cases à cocher au lieu d'un menu déroulant
                'label' => 'Boite de vitesse :', // Libellé du champ
                'required' => true, // Champ requis
                "attr"=>[
                    "class"=>"form-control"
                ],
            ])
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Familiale' => 'Familiale',
                    'Luxe' => 'Luxe',
                    'SUV' => 'SUV',
                    'Berline' => 'Berline',
                    'Sport' => 'Sport',
                ],
                'expanded' => true, // Permet de rendre les cases à cocher au lieu d'un menu déroulant
                'label' => 'Catégorie :', // Libellé du champ
                'required' => true, // Champ requis
                "attr"=>[
                    "class"=>"form-control"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Type::class,
        ]);
    }
}
