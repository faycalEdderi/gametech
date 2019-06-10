<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticlesType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewArticleController extends AbstractController
{
    /**
     * @Route("admin/new/article", name="new_article")
     * @Route("/admin/update/{id}", name="article.update")
     */
    public function index(Request $request, ObjectManager $objectManager, int $id = null, ArticleRepository $articleRepository):Response
    {
        $entity = $id ? $articleRepository->find($id) : new Article();
        $type = ArticlesType::class;

        $entity->prevImage = $entity->getImage();

		//dd($entity);
		$form = $this->createForm($type, $entity);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            if(!$entity->getId()){
                $imageName = bin2hex(random_bytes(16));
				$uploadedFile = $entity->getImage(); // renvoie un objet UploadedFile
				$extension = $uploadedFile->guessExtension();
                $uploadedFile->move('img/', "$imageName.$extension");
                
                $entity->setImage("$imageName.$extension");
            }
            elseif($entity->getId() && !$entity->getImage()){
				// récupération de la propriété dynamique prevImage pour remplir la propriété image
				$entity->setImage( $entity->prevImage );
				//dd($entity);
            }
            elseif($entity->getId() && $entity->getImage()){
				// unlink : suppression de l'ancienne image
				unlink("img/{$entity->prevImage}");

				// transfert de la nouvelle image
				$imageName = bin2hex(random_bytes(16));
				$uploadedFile = $entity->getImage();
				$extension = $uploadedFile->guessExtension();
				$uploadedFile->move('img/', "$imageName.$extension");
				$entity->setImage("$imageName.$extension");
            }
            
            
			// si l'entité est mise à jour et qu'une image n'a pas été sélectionnée
			elseif($entity->getId() && !$entity->getImage()){
				// récupération de la propriété dynamique prevImage pour remplir la propriété image
				$entity->setImage( $entity->prevImage );
				//dd($entity);
			}
			// si l'entité est mise à jour et qu'une image a été sélectionnée
			elseif($entity->getId() && $entity->getImage()){
				// unlink : suppression de l'ancienne image
				unlink("img/{$entity->prevImage}");

				// transfert de la nouvelle image
				$imageName = bin2hex(random_bytes(16));
				$uploadedFile = $entity->getImage();
				$extension = $uploadedFile->guessExtension();
				$uploadedFile->move('img/', "$imageName.$extension");
				$entity->setImage("$imageName.$extension");
			}
       
            $objectManager->persist($entity);
			$objectManager->flush();
 
            //$this->addFlash('notice', 'L\'article été ajouté');
 
            return $this->redirectToRoute('articles.dev');
         }

        return $this->render('new_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
	}
	
	
}
