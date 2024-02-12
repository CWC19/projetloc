<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immat',TextType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('prix', NumberType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('couleur',ColorType::class,["attr"=>["class"=>"form-control"], "label_attr"=>["class"=>""]])
            ->add('photo1',  FileType::class, [
                'label' => 'photo 1',
                'mapped' => false, //importer image
                'constraints' => [
                    new File([
                        'maxSize' => '8Mi', //taille max
                        'mimeTypes' => [ //type d'elem pouvant etre importées
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid img document', //si l'ext n'est pas respecter
                    ])
                ],
            ])
            ->add('photo2',  FileType::class, [
                'required' => false,
                'label' => 'photo 2',
                'mapped' => false, //importer image
                'constraints' => [
                    new File([
                        'maxSize' => '8Mi', //taille max
                        'mimeTypes' => [ //type d'elem pouvant etre importées
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid img document', //si l'ext n'est pas respecter
                    ])
                ],
            ] )
            ->add('photo3',  FileType::class, [
                'label' => 'photo 3',
                'mapped' => false, //importer image
                'constraints' => [
                    new File([
                        'maxSize' => '8Mi', //taille max
                        'mimeTypes' => [ //type d'elem pouvant etre importées
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid img document', //si l'ext n'est pas respecter
                    ])
                ],
            ] )
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
