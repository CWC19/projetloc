<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_p', DateType::class, ["attr"=>["class"=>"form-control", ], "label" => "Date :", "label_attr"=>["class"=>""]])
            ->add('note', RangeType::class, ["attr"=>["class"=>"form-control"],'attr' => [
                'min' => 1,
                'max' => 5
            ], "label_attr"=>["class"=>""]])
            ->add('texte', TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('auteur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'id',
            ])
            ->add('reservation_id', EntityType::class, [
                'class' => Reservation::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
