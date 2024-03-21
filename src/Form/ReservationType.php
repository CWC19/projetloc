<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Required;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prixTT', NumberType::class, [
                'disabled' => true,
                "attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('date_deb', DateType::class, [
                'disabled' => true,
                "attr"=>
            ["class"=>"form-control", ], "label_attr"=>["class"=>""]])
            ->add('date_fin', DateType::class, [
                'disabled' => true,
                "attr"=>["class"=>"form-control", ], "label_attr"=>["class"=>""]])
            ->add('client', EntityType::class, [
                'disabled' => true,
                'class' => Utilisateur::class,
                'choice_label' => function ($user) {
                    return 'Nom : '.$user->getNom() . ', Prénom : ' . $user->getPrenom() . ', Email : ' . $user->getEmail();
                },
            ])
            ->add('voiture', EntityType::class, [
                'disabled' => true,
                'class' => Voiture::class,
                'choice_label' => function ($voiture) {
                    return 'Immatriculation : '.$voiture->getImmat() . ', Marque : ' .$voiture->getType()->getMarque(). ', Model : '. $voiture->getType()->getModel()
                    . ', Puissance : '. $voiture->getType()->getPuissance(). ', Carburant : '. $voiture->getType()->getCarburant(). ', Boîte : '. $voiture->getType()->getBoiteVitesse()
                    . ', Catégorie : '. $voiture->getType()->getCategorie(); 
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
