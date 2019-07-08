<?php

namespace App\Form;

use App\Entity\Topic;

use App\Entity\CategoryTopic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CreateTopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet', TextType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir un texte"
		            ]),
		            new Length([
                        'min' => 10,
                        'max' => 150,
                        'minMessage' => 'Le texte doit comporter au minimum {{ limit }} caractères',
			            'maxMessage' => 'Le texte doit comporter au maximum {{ limit }} caractères',
		            ])
	            ]
			])
            ->add('auteur', HiddenType::class, [

				'constraints' => [
		            new NotBlank() 
	            ]
 
				])
            ->add('message', TextareaType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir un texte"
		            ]),
		            new Length([
			            'min' => 10,
			            'minMessage' => 'Le texte doit comporter au minimum {{ limit }} caractères',
		            ])
	            ]
			])
			->add('category_topic', EntityType::class, [
				
	        	'class' => CategoryTopic::class,
				'choice_label' => 'category_name',
				'placeholder'=>"",
				'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir une categorie"
		            ])]
					        
		      
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
