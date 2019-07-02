<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\ModifMdpType;
use App\Form\AjoutUserType;
use App\Form\ModifUserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\TopicRepository;
use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DevController extends AbstractController
{
    /**
     * @Route("/admin", name="accueil.dev")
     */
    public function accueil():Response
    {
        

        return $this->render('dev/accueil.html.twig');
    }
/**
 * @Route("/admin/articles", name="articles.dev")
 */
    public function index(ArticleRepository $articleRepository):Response
    {
        $result = $articleRepository->findAll();

        return $this->render('dev/article.html.twig', [
            'afficher' => $result,
        ]);
    }

    // suppression d'un article
	/**
	 * @Route("/admin/delete/{id}", name="article.delete")
	 */
	public function delete(int $id, ArticleRepository $articleRepository, ObjectManager $objectManager):Response
	{
		// sélection de l'entité par son identifiant
		$entity = $articleRepository->find($id);

		// suppression de l'entité
		$objectManager->remove($entity);
		$objectManager->flush();

		// suppression de l'image
		unlink("img/{$entity->getImage()}");

		// message
		$this->addFlash('notice', "L'artice a été supprimé");

		// redirection
		return $this->redirectToRoute('articles.dev');
	}

	 /**
     * @Route("/admin/user", name="user.dev")
     */
    public function user(UserRepository $userRepository):Response
    {
        $result = $userRepository->findAll();

        return $this->render('dev/user.html.twig', [
            'afficher' => $result,
        ]);
    }

    // suppression d'un utilisateur
	/**
	 * @Route("/admin/deleteUser/{id}", name="user.delete")
	 */
	public function userDelete(int $id, UserRepository $userRepository, ObjectManager $objectManager):Response
	{
        
		// sélection de l'entité par son identifiant
		$entity = $userRepository->find($id);

		// suppression de l'entité
		$objectManager->remove($entity);
		$objectManager->flush();

		

		// message
		$this->addFlash('notice', "L'utilisateur a été supprimé");

		// redirection
		return $this->redirectToRoute('user.dev');
	}

    /**
     * @Route("admin/new/user", name="new.user")
     */
    public function newUser(Request $request, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = $id ? $userRepository->find($id) : new User();
        $type = RegistrationFormType::class;

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
           
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // message
		    $this->addFlash('notice', "L'utilisateur a été ajouté");
            return $this->redirectToRoute('user.dev');
         }

        return $this->render('dev/newUser.html.twig', [
            'form' => $form->createView(),
        ]);
   
    }
    

    /**
     * @Route("/admin/updateUser/{id}", name="user.update")
     */
    public function updateUser(Request $request, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = $id ? $userRepository->find($id) : new User();
        $type = ModifUserType::class;

 
        $form = $this->createForm(ModifUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

 
            return $this->redirectToRoute('user.dev');
         }

        return $this->render('dev/updateUser.html.twig', [
            'form' => $form->createView(),
        ]);
   
    }
    
    /**
     * @Route("/admin/modifMdp/{id}", name="modif.mdp")
     */
    public function modifMdp(Request $request, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = $id ? $userRepository->find($id) : new User();
        $type = ModifMdpType::class;

        $form = $this->createForm(ModifMdpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

 
            return $this->redirectToRoute('user.profile');
         }

        return $this->render('dev/modifMdp.html.twig', [
            'form' => $form->createView(),
        ]);
   
	}
    

// AFFICHAGE DES MESSAGES DU FORMULAIRE DE CONTACT
     /**
     * @Route("/admin/msg", name="msg.dev")
     */
    public function msg(ContactRepository $contactRepository):Response
    {
        $result = $contactRepository->findAll();

        return $this->render('dev/message.html.twig', [
            'afficher' => $result,
        ]);
    }

    /**
     * @Route("/admin/message/{id}", name="message.details")
     */
    public function details(int $id, ContactRepository $contactRepository):Response
    {
        $result = $contactRepository->find($id);
        //dd($result);
        return $this->render('dev/msgDetails.html.twig', [
            'afficher' => $result,
        ]);
    }

    // suppression d'un message
	/**
	 * @Route("/admin/deleteMsg/{id}", name="msg.delete")
	 */
	public function msgDelete(int $id, ContactRepository $contactRepository, ObjectManager $objectManager):Response
	{
		// sélection de l'entité par son identifiant
		$entity = $contactRepository->find($id);

		// suppression de l'entité
		$objectManager->remove($entity);
		$objectManager->flush();

		

		// message
		$this->addFlash('notice', "le message a été supprimé");

		// redirection
		return $this->redirectToRoute('msg.dev');
	}

//Affichage des Forum 

 /**
     * @Route("/admin/forum", name="forum.dev")
     */
    public function forum(TopicRepository $topicRepository):Response
    {
        $result = $topicRepository->findAll();

        return $this->render('dev/forum.html.twig', [
            'afficher' => $result,
        ]);
    }


    //Suppression FORUM

	/**
	 * @Route("/admin/deleteTopic/{id}", name="topic.delete")
	 */
	public function topicDelete(int $id, TopicRepository $topicRepository, ObjectManager $objectManager):Response
	{
		// sélection de l'entité par son identifiant
		$entity = $topicRepository->find($id);

		// suppression de l'entité
		$objectManager->remove($entity);
		$objectManager->flush();

		

		// message
		//$this->addFlash('notice', "Le produit a été supprimé");

		// redirection
		return $this->redirectToRoute('forum.dev');
	}

    
  



}
