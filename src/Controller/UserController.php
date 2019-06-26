<?php

namespace App\Controller;


use App\Form\ModifMdpType;
use App\Form\ModifUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
