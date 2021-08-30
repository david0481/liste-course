<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/article", name="api_liste", methods={"GET"})
     */
    public function liste(ArticleRepository $repo): Response
    {
        $tab = $repo->findAll();
       // $tab["message"] = "Liste des articles";
        return $this->json($tab);
    }

     /**
     * @Route("/api/article", name="api_ajouter", methods={"POST"})
     */
    public function ajouter(Request $req, EntityManagerInterface $em): Response
    {
        // objet PHP = un objet JS (body) 
        $objet = json_decode($req ->getContent());
        //$objet->nom;
        //$objet->prenom;
        $a = new Article();
        $a->setNom($objet->nom);
        $a->setQuantite($objet->quantite);
        $a->setIsOk($objet->isOk);

        $em->persist($a);
        $em->flush();
        return $this->json($a);
    }

     /**
     * @Route("/api/article/{id}", name="api_modifier", methods={"PUT"})
     */
    public function modifier(Article $a,Request $req,EntityManagerInterface $em): Response
    {
       // objet PHP = un objet JS (body) 
       $objet = json_decode($req ->getContent());
       // hydrater la personne
       $a->setNom($objet->nom);
       $a->setQuantite($objet->quantite);
       $a->setIsOk($objet->isOk);

       $em->flush();

        return $this->json($a);
    }

     /**
     * @Route("/api/article/{id}", name="api_delete", methods={"DELETE"})
     */
    public function delete(Article $article, EntityManagerInterface $em): Response
    {
       $em->remove($article);
       $em->flush();

        return $this->json($article);
    }
}
