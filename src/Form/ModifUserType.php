<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ModifUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir une adresse mail"
		            ]),
		          
	            ]
			])
            
            
            ->add('nom', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir un nom"
                    ]),
                    new Length([
		            	'min' => 2,
			            'max' => 50,
			            'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères',
			            'maxMessage' => 'Le nom ne doit pas depasser  {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('prenom', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir un prenom"
                    ]),
                    new Length([
		            	'min' => 2,
			            'max' => 50,
			            'minMessage' => 'Le prenom doit comporter au moins {{ limit }} caractères',
			            'maxMessage' => 'Le prenom ne doit pas depasser  {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('region', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir une region"
                    ]),
                    new Length([
		            	'min' => 2,
			            'max' => 150,
			            'minMessage' => 'La region doit comporter au moins {{ limit }} caractères',
			            'maxMessage' => 'La region ne doit pas depasser  {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('age', NumberType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir un age"
                    ]),
                    new Length([
		            	'min' => 1,
			            'max' => 3,
			            'minMessage' => 'L\'âge ne peut etre inferieur à {{ limit }} nombre ',
			            'maxMessage' => 'L\'âge ne peut pas contenir plus de {{ limit }} nombres, à moins que ...',
		            ])
	            ]
            ])
            ->add('sexe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
