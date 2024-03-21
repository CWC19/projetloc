<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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

        
            ->add('nom',TextType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-6"], "label_attr"=>["class"=>""]])
            ->add('prenom',TextType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-6"], "label_attr"=>["class"=>""]])
            ->add('permis', TextType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('email',EmailType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('dof', TypeDateType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-6"], 
                    "label"=>"Date de naissance :", 
                    "label_attr"=>["class"=>""]])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Femme' => 'femme',
                    'Homme' => 'homme',
                ],
                'expanded' => true, // Permet de rendre les cases à cocher au lieu d'un menu déroulant
                'label' => 'Genre', // Libellé du champ
                'required' => true, // Champ requis
            ])
            ->add('tel', TelType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control"], "label"=>"N° de téléphone :", "label_attr"=>["class"=>""]])
            ->add('adresse',TextType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('ville', TextType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-4"], "label_attr"=>["class"=>""]])
            ->add('cp', NumberType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-4"], "label_attr"=>["class"=>""]])
            ->add('pays', ChoiceType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-4"],
                "multiple"=>true,
                "choices"=>[
                    
                    "France"=>"France", //"label"->"valeur" (valeur=stocker dans bdd)
                    "Espagne"=>"Espagne"
                ]
            ])            
            ->add('password',RepeatedType::class,[
                'required' => true, 
                "type"=>PasswordType::class,
                "attr"=>["class"=>"form-control col-md-6"],
                "first_options"=>["label"=>"Mot de passe","attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]],
                "second_options"=>["label"=>"Vérification du mot de passe","attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]]
            ])            
            ->add('roles', ChoiceType::class,[
                'required' => true,
                "attr"=>["class"=>"form-control col-md-6"],
                "multiple"=>true,
                "choices"=>[
                    "Admin"=>"ROLE_ADMIN", //"label"->"valeur" (valeur=stocker dans bdd)
                    "Client"=>"ROLE_CLIENT"
                ],
                'disabled' => $options['disabled_role_field'], // Désactivez le champ si l'option est définie à true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'disabled_role_field' => false, // Par défaut, le champ du rôle n'est pas désactivé
        ]);

        $resolver->setAllowedTypes('disabled_role_field', 'bool'); // Assurez-vous que l'option est un booléen
        
    }
}
