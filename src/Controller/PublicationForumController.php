<?php

namespace App\Controller;

use App\Entity\PublicationForum;
use App\Repository\TopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicationForumController extends AbstractController
{
    /**
     * @Route("/publication/forum", name="publication_forum")
     */
    public function reponseForum(Request $request, TopicRepository $topicRepository, ObjectManager $objectManager):JsonResponse
    {
		$userName = $request->request->get('userName');
		
		
		$message = $request->request->get('message');
//empeche la publication de reponse vite
		if( !empty($message) ){
		
		$id = $request->request->get('id');
		//dd($message, $id);


		$publication = new PublicationForum();
		$publication->setReponse($message);
		$publication->setUserName($userName);



		$topic = $topicRepository->find($id);
		//dd($product);

		// associer une entité à une autre entité : utiliser une entité dans une méthode de l'autre entité
		$publication->setTopic($topic);

		// enregistrement dans la table
		$objectManager->persist($publication);
		$objectManager->flush();
		//dd($comment);


		$topic = $topicRepository->find($id);
		$response = new JsonResponse( $topic->getPublication()->toArray() );

		//dd($product->getCommentaire()->toArray());

		return $response;
		}
	}
		
}
