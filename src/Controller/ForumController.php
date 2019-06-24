<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\CreateTopicType;
use App\Repository\TopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{/**
     * @Route("/forum", name="forum")
     */
    public function listTopic(TopicRepository $topicRepository):Response
    {
		$results = $topicRepository->findAll();
        return $this->render('forum/listForum.html.twig', [
            'afficher'=> $results
        ]);
	}
    /**
     * @Route("/user/forum/newTopic", name="newTopic")
     */
    public function newTopic(Request $request, ObjectManager $objectManager):Response
    {
		//condition si l'id n'est pas vide 
        $entity = new Topic();
        $type = CreateTopicType::class;

        

		
		$form = $this->createForm($type, $entity);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
         
           
            $objectManager->persist($entity);
			$objectManager->flush();
 
            //$this->addFlash('notice', 'Le topic a bien été créé');
 
            return $this->redirectToRoute('forum');
         }

        return $this->render('forum/newTopic.html.twig', [
            'form' => $form->createView(),
        ]);
	}
}
