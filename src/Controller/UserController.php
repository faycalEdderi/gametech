<?php

namespace App\Controller;


use App\Form\ModifMdpType;
use App\Form\ModifUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
      /**
     * @Route("/user/profile", name="user.profile")
     */
    public function profile():Response
    {
       
        return $this->render('user/profile.html.twig');
    }

    /**
     * @Route("/user/modifierProfile/{id}", name="profile.update")
     */
    public function modifierProfile(Request $request, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = $id ? $userRepository->find($id) : new User();
        $type = ModifUserType::class;

        $form = $this->createForm(ModifUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // message
            $this->addFlash('notice', "Les informations ont été modifiés");
            
            return $this->redirectToRoute('user.profile');
         }

        return $this->render('user/modifProfile.html.twig', [
            'form' => $form->createView(),
        ]);
   
    }

    // suppression de compte utilisateur
	/**
	 * @Route("/user/deleteUser/{id}", name="user.supprimer")
	 */
	public function userDelete(int $id, UserRepository $userRepository, ObjectManager $objectManager, TokenStorageInterface $tokenStorage, SessionInterface $session):Response
	{   

        
    
		// sélection de l'entité par son identifiant
        $entity = $userRepository->find($id);
        
		// suppression de l'entité
        $objectManager->remove($entity); 

        
        $objectManager->flush();
        $tokenStorage->setToken(null);
        $session->invalidate();

        // message
        $this->addFlash('notice', "Votre compte a été supprimé");
        return $this->redirectToRoute('accueil');
        
        
       
		
     
	}


//USER MODIFIE MDP

    /**
     * @Route("/user/mdp/{id}", name="user.changeMdp")
     */
    public function changeMdp(Request $request, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
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

            // message
            $this->addFlash('notice', "Le mot de passe a été modifié");
            
            return $this->redirectToRoute('user.profile');
         }

        return $this->render('user/modifMdp.html.twig', [
            'form' => $form->createView(),
        ]);
   
	}

 
  
}
