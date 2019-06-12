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

    /**
     * @Route("/nouveau", name="nouveau")
     */
    public function nouveau(ArticleRepository $articleRepository):Response
    {
       $results = $articleRepository->findByCategory("nouveaute");
       return $this->render('categories/categorie.html.twig', [
           'afficher'=> $results
       ]);
    }

    /**
     * @Route("/ps4", name="ps4")
     */
    public function ps4(ArticleRepository $articleRepository):Response
    {
       $results = $articleRepository->findByCategory("playstation 4");
       return $this->render('categories/categorie.html.twig', [
           'afficher'=> $results
       ]);
    }

       /**
     * @Route("/xbox", name="xbox")
     */
    public function xboxOne(ArticleRepository $articleRepository):Response
    {
       $results = $articleRepository->findByCategory("xbox one");
       return $this->render('categories/categorie.html.twig', [
           'afficher'=> $results
       ]);
    }

       /**
     * @Route("/pc", name="pc")
     */
    public function pc(ArticleRepository $articleRepository):Response
    {
       $results = $articleRepository->findByCategory("pc");
       return $this->render('categories/categorie.html.twig', [
           'afficher'=> $results
       ]);
    }

      /**
     * @Route("/article/{id}", name="article.details")
     */
    public function details(int $id, ArticleRepository $articleRepository):Response
    {
        $result = $articleRepository->find($id);
        //dd($result);
        return $this->render('principal/details.html.twig', [
            'article' => $result,
        ]);
    }

 
  
}
