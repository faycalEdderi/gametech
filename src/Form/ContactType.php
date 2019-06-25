<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir votre adresse mail"
		            ]),
		          
	            ]
			])
            ->add('objet', TextType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir un sujet"
		            ]),
		            new Length([
                        'min' => 10,
                        'max' => 10,
                        'maxMessage' => 'Votre sujet doit comporter au maximum{{ limit }} caractères',
			            'minMessage' => 'Votre sujet comporter au minimum {{ limit }} caractères',
		            ])
	            ]
			])
            ->add('message', TextareaType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir votre message"
		            ]),
		            new Length([
                        'min' => 10,
                        'max' => 1000,
                        'maxMessage' => 'Votre message doit comporter au maximum{{ limit }} caractères',
			            'minMessage' => 'Votre message comporter au minimum {{ limit }} caractères',
		            ])
	            ]
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
