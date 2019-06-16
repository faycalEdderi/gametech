<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\AjoutUserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DevController extends AbstractController
{
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
		$this->addFlash('notice', "Le produit a été supprimé");

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
		$this->addFlash('notice', "l'utilisateur a été supprimé");

		// redirection
		return $this->redirectToRoute('user.dev');
	}

    /**
     * @Route("admin/new/user", name="new.user")
     * @Route("/admin/updateUser/{id}", name="user.update")
     */
    public function newUser(Request $request, ObjectManager $objectManager, int $id = null, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder):Response
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

 
            return $this->redirectToRoute('user.dev');
         }

        return $this->render('dev/newUser.html.twig', [
            'form' => $form->createView(),
        ]);
	}

    


}
