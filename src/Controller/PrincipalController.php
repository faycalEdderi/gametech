<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ArticleRepository $articleRepository):Response
    {
       $results = $articleRepository->findAll();
       return $this->render('principal/accueil.html.twig', [
           'afficher'=> $results
       ]);
    }
}
