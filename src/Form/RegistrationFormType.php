<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
              
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir votre email"
                    ]), 
	            ]
            ])
            ->add('nom', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir votre nom"
                    ]),
                    new Length([
		            	'min' => 2,
			            'max' => 50,
			            'minMessage' => 'Votre nom doit comporter au moins {{ limit }} caractères',
			            'maxMessage' => 'Votre nom ne doit pas depasser  {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('prenom', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir votre prenom"
                    ]),
                    new Length([
		            	'min' => 2,
			            'max' => 50,
			            'minMessage' => 'Votre prenom doit comporter au moins {{ limit }} caractères',
			            'maxMessage' => 'Votre prenom ne doit pas depasser  {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('region', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir votre region"
                    ]),
                    new Length([
		            	'min' => 2,
			            'max' => 150,
			            'minMessage' => 'Votre region doit comporter au moins {{ limit }} caractères',
			            'maxMessage' => 'Votre region ne doit pas depasser  {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('age', NumberType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir votre age"
                    ]),
                    new Length([
		            	'min' => 1,
			            'max' => 2,
			            'minMessage' => 'Votre age ne peut etre inferieur à {{ limit }} chiffres ',
			            'maxMessage' => 'votre age ne peut pas contenir plus de {{ limit }} chiffres',
                    ]), 
                    new LessThanOrEqual([
                        'value'=> 99,
                        'message' => "Votre age ne doit pas depasser 99 ans" 
                    ]), 
                    new GreaterThanOrEqual([
                        'value'=> 15,
                        'message' => "Vous etes trop jeune pour vous inscrire" 
                    ])
	            ]
            ])
            ->add('sexe', ChoiceType::class, [
                'expanded'=> true,
                'multiple'=>false,
                'choices'=> [
                    'gameure'=>'homme', 
                    'gameuse'=>'femme'
                ], 
                'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez choisir un genre"
					]),
				]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
