<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$entity = $options['data'];
		$constraintsImage = [
			new Image([
				'mimeTypes' => [ 'image/jpeg', 'image/gif', 'image/png', 'image/svg+xml', 'image/webp' ],
				'mimeTypesMessage' => "Formats d'image acceptés: jpeg, gif, png, webp."
			])
		];

		if(!$entity->getId()){
    		array_push(
		        $constraintsImage,
			    new NotBlank([
				    'message' => 'Veuillez sélectionner une image'
			    ])
	        );
	    }


		
        $builder
            ->add('titre', TextType::class, [
            	'constraints' => [
            		new NotBlank([
            			'message' => "Veuillez saisir un titre"
		            ]),
		            new Length([
		            	'min' => 2,
			            'max' => 150,
			            'minMessage' => 'Le titre de l\'article doit comporter au minimum {{ limit }} caractères',
			            'maxMessage' => 'Le titre de l\'article {{ limit }} caractères',
		            ])
	            ]
            ])
            ->add('image', FileType::class, [
				
            	'constraints' => $constraintsImage,
	            'help' => 'Veuillez sélectionner une image au format JPG, GIF, PNG, SVG ou WebP',
	            'data_class' => null
            ])
            ->add('texte', TextareaType::class, [
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
			->add('accroche', TextareaType::class, [
            	'constraints' => [
		            new NotBlank([
			            'message' => "Veuillez saisir un texte d'accroche"
		            ]),
		            new Length([
			            'max' => 150,
			            'maxMessage' => 'Le texte doit comporter maximum {{ limit }} caractères',
		            ])
	            ]
			])
			->add('categorie', EntityType::class, [
                'class'=>Categorie::class, 
                'choice_label'=>"name",
                'placeholder'=>""
        
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
