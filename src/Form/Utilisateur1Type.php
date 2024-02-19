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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class Utilisateur1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        
            ->add('nom',TextType::class,["attr"=>["class"=>"form-control col-md-6"], "label_attr"=>["class"=>""]])
            ->add('prenom',TextType::class,["attr"=>["class"=>"form-control col-md-6"], "label_attr"=>["class"=>""]])
            ->add('permis', TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('email',EmailType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('dof', TypeDateType::class,["attr"=>["class"=>"form-control col-md-6"], 
                    "label"=>"Date de naissance :", 
                    "label_attr"=>["class"=>""]])
            ->add('sexe', TextType::class,["attr"=>["class"=>"form-control col-md-6"], "label_attr"=>["class"=>""]])
            ->add('tel', TelType::class,["attr"=>["class"=>"form-control"], "label"=>"N° de téléphone :", "label_attr"=>["class"=>""]])
            ->add('adresse',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('ville', TextType::class,["attr"=>["class"=>"form-control col-md-4"], "label_attr"=>["class"=>""]])
            ->add('cp', NumberType::class,["attr"=>["class"=>"form-control col-md-4"], "label_attr"=>["class"=>""]])
            ->add('pays', ChoiceType::class,[
                "attr"=>["class"=>"form-control col-md-4"],
                "multiple"=>true,
                "choices"=>[
                    "France"=>"France", //"label"->"valeur" (valeur=stocker dans bdd)
                    "Espagne"=>"Espagne"
                ]
            ])            
            ->add('password',RepeatedType::class,[
                'constraints' => [
                    new Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', $message="Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et 12 caractères. ")
                ], 
                "type"=>PasswordType::class,
                "attr"=>["class"=>"form-control col-md-6"],
                "first_options"=>["label"=>"Mot de passe","attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]],
                "second_options"=>["label"=>"Vérification du mot de passe","attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]]
            ])            
            ->add('roles', ChoiceType::class,[
                "attr"=>["class"=>"form-control col-md-6"],
                "multiple"=>true,
                "choices"=>[
                    "Admin"=>"ROLE_ADMIN", //"label"->"valeur" (valeur=stocker dans bdd)
                    "Client"=>"ROLE_CLIENT"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
