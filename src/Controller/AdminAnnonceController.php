<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\PhotosRepository;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAnnonceController extends AbstractController
{
    /**
     * affichage des annonces
     * 
     * @Route("/admin/annonce", name="admin_annonce")
     */
    public function index(AnnonceRepository $repo)
    {
        $annonce = $repo->findBy([], ["createdAt" => "DESC"]);
        return $this->render('admin/annonce.html.twig', [
            'annonce' => $annonce
        ]);
    }

    
    /**
     * affichage de l'annonce
     * 
     * @Route("/admin/annonceof/{id}", name="show_annonce")
     */
    public function show(Annonce $annonce)
    {
        return $this->render('admin/annonce_show.html.twig',[
            'annonce' => $annonce
        ]);
    }

    /**
     * suppression de l'annonce
     * 
     * @Route("/admin/annonce/{id}", name="supAnnonce", methods="delete")
     */
    public function suppression(Annonce $annonce, EntityManagerInterface $manager, Request $req, PhotosRepository $repo)
    {
        if ($this->isCsrfTokenValid('SUP' . $annonce->getId(), $req->get('_token'))) {
            $dist = dirname(__DIR__,2) . '/public/images/annonce/';
            $images = $repo->findBy(["annonce" => $annonce]);

            foreach ($images as $image) {
                unlink($dist.$image->getSrc());
                $manager->remove($image);
                $manager->flush();
            }

            $manager->remove($annonce);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("admin_annonce");
        }
    }

    /**
     * validation de l'annonce
     * 
     * @Route("/admin/annonce/{id}", name="validAnnonce", methods="valid")
     */
    public function validation(Annonce $annonce, EntityManagerInterface $manager, Request $req)
    {
        if ($this->isCsrfTokenValid('VAL' . $annonce->getId(), $req->get('_token'))) {

            $annonce->setStatus(1);
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash("success", "la validation a bien été éffectuée");
            return $this->redirectToRoute("admin_annonce");
        }
    }
}
