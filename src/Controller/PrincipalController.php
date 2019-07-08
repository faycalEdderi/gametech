<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(ArticleRepository $articleRepository, TopicRepository $topicRepository):Response
    {
       $results = $articleRepository->findAll();
       $topic = $topicRepository->findAll();
       return $this->render('principal/accueil.html.twig', [
           'afficher'=> $results,
           'afficherTopic'=> $topic
       ]);
    }


    /**
     * @Route("/notfound", name="notfound")
     */
    public function notFound():Response
    {
       
       return $this->render('404/404.html.twig');
    }


     /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu():Response
    {
       
       return $this->render('principal/cgu.html.twig');
    }

    /**
     * @Route("/nintendo", name="nintendo")
     */
    public function nintendo(ArticleRepository $articleRepository):Response
    {
       $results = $articleRepository->findByCategory("nintendo");
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
