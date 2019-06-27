<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire/add", name="commentaire.add")
     */
    public function add(Request $request, ArticleRepository $articleRepository, ObjectManager $objectManager):JsonResponse
    {
		$userName = $request->request->get('userName');
		
		
		$message = $request->request->get('message');
		//empeche la publication de commentaire vide
			if( !empty($message) ){
			$id = $request->request->get('id');
			//dd($message, $id);

			
			$commentaire = new Commentaire();
			$commentaire->setMessage($message);
			$commentaire->setUserName($userName);
			

			
			$article = $articleRepository->find($id);
			//dd($product);

			// associer une entité à une autre entité : utiliser une entité dans une méthode de l'autre entité
			$commentaire->setArticle($article);

			// enregistrement dans la table
			$objectManager->persist($commentaire);
			$objectManager->flush();
			//dd($comment);

		
			$article = $articleRepository->find($id);
			$response = new JsonResponse( $article->getCommentaire()->toArray() );

			//dd($product->getCommentaire()->toArray());

			return $response;
		}
    }
}
