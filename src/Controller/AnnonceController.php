<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\ActuRepository;
use App\Repository\AnnonceCatRepository;
use App\Repository\AnnonceRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    /**
     * affichage des annonces
     * 
     * @Route("/les_annonces", name="annonce")
     *
     * @return void
     */
    public function index(AnnonceRepository $repo_annonce, ActuRepository $repo_actu){

        $show_annonce = $repo_annonce->findBy(["status" => 1], ["createdAt" => "DESC"]);
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/index.html.twig', [
            'annonce' => $show_annonce,
            'side_actu' => $actus,
        ]);
    }

    /**
     * detail de l'annonce a partir de la page d'affichage général
     * 
     * @Route("/les_annonces/{slug}", name="annonce_show")
     *
     * @return void
     */
    public function annonceShow(Annonce $annonce, ActuRepository $repo_actu){

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/annonce_show.html.twig', [
            "annonce" => $annonce,
            'side_actu' => $actus
        ]);
    }

    /**
     * @Route("/annonce/{cat}", name="annonce_cat")
     * 
     * @return void
     */
    public function annonceCat(AnnonceCatRepository $repo, $cat, ActuRepository $repo_actu)
    {
        $category = $repo->findOneBy(['libelle' => $cat]);
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/annonceCat.html.twig', [
            'category' => $category,
            'side_actu' => $actus
        ]);
    }

        /**
     * detail de l'annonce a partir de la page de la catégorie concerné
     * 
     * @Route("/annonces/{cat}/{slug}", name="annonce_detail")
     *
     * @return void
     */
    public function annonceDetail(Annonce $annonce, ActuRepository $repo_actu){

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/annonce_detail.html.twig', [
            "annonce" => $annonce,
            'side_actu' => $actus
        ]);
    }
    

}
