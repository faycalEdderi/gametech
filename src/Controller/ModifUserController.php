<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ModifMdpType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ModifUserController extends AbstractController
{
    /**
     * @Route("/dev/modif/mdp/{id}", name="modif2.mdp")
     */
    public function modifMdp(Request $request, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user = $id ? $userRepository->find($id) : new User();
        $type = ModifMdpType::class;

        $form = $this->createForm(ModifMdpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

 
            return $this->redirectToRoute('user.profile');
         }

        return $this->render('user/modifMdp.html.twig', [
            'form' => $form->createView(),
        ]);
   
	}
}
