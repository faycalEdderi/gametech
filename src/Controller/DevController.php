<?php

namespace App\Controller;


use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    


}
