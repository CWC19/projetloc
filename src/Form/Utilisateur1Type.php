<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Utilisateur1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('prenom',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('permis', TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('email',EmailType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('dof', TypeDateType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('sexe', TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('tel', TelType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('adresse',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('ville', TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('cp', NumberType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('pays', ChoiceType::class,[
                "attr"=>["class"=>"form-control "],
                "multiple"=>true,
                "choices"=>[
                    "France"=>"France", //"label"->"valeur" (valeur=stocker dans bdd)
                    "Espagne"=>"Espagne"
                ]
            ])            
            ->add('password',RepeatedType::class,[
                "type"=>PasswordType::class,
                "attr"=>["class"=>"form-control"],
                "first_options"=>["label"=>"mot de passe","attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]],
                "second_options"=>["label"=>"mot de passe(vérification)","attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]]
            ])            
            ->add('roles', ChoiceType::class,[
                "attr"=>["class"=>"form-control "],
                "multiple"=>true,
                "choices"=>[
                    "Admin"=>"ADMIN", //"label"->"valeur" (valeur=stocker dans bdd)
                    "Client"=>"CLIENT"
                ]
            ])
            ->add('save', SubmitType::class,["attr"=>["class"=>"btn btn-primary mt-3 "]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
