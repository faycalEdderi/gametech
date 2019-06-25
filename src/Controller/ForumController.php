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
     * @Route("/topic/{id}", name="topic.details")
     */
    public function topicDetails(int $id, TopicRepository $topicRepository):Response
    {
        $result = $topicRepository->find($id);
        //dd($result);
        return $this->render('forum/ForumDetails.html.twig', [
            'afficher' => $result,
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
    
    /**
     * @Route("/forum/nintendo", name="forum.nintendo")
     */
    public function forumNintendo(TopicRepository $topicRepository):Response
    {
       $results = $topicRepository->findByCategory("switch");
       return $this->render('forum/forumCategorie.html.twig', [
           'afficher'=> $results
       ]);
    }
     /**
     * @Route("/forum/playstation", name="forum.playstation")
     */
    public function forumPlaystation(TopicRepository $topicRepository):Response
    {
       $results = $topicRepository->findByCategory("playstation");
       return $this->render('forum/forumCategorie.html.twig', [
           'afficher'=> $results
       ]);
    }
     /**
     * @Route("/forum/xbox", name="forum.xbox")
     */
    public function forumXbox(TopicRepository $topicRepository):Response
    {
       $results = $topicRepository->findByCategory("xbox");
       return $this->render('forum/forumCategorie.html.twig', [
           'afficher'=> $results
       ]);
    }
     /**
     * @Route("/forum/pc", name="forum.ordinateur")
     */
    public function forumordinateur(TopicRepository $topicRepository):Response
    {
       $results = $topicRepository->findByCategory("ordinateur");
       return $this->render('forum/forumCategorie.html.twig', [
           'afficher'=> $results
       ]);
    }
     /**
     * @Route("/forum/divers", name="forum.divers")
     */
    public function forumDivers(TopicRepository $topicRepository):Response
    {
       $results = $topicRepository->findByCategory("divers");
       return $this->render('forum/forumCategorie.html.twig', [
           'afficher'=> $results
       ]);
    }
}
