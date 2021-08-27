<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();

        return $this->render('main/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();

        $article->setNom($request->get('nomArticle'));
        $article->setQuantite($request->get('nbArticle'));
        $article->setIsOk(false);

        $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Article $article, EntityManagerInterface $em): Response
    {
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifier(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        $isOk = $article->getIsOk();
        
         if($isOk == false){
            $article->setIsOk(true);
        }else{
            $article->setIsOk(false);
        }

        $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('home');

    }



}
