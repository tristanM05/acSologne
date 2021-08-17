<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Service\Uploader;
use App\Repository\ActuRepository;
use App\Repository\PhotosRepository;
use App\Service\AnnonceNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAnnonceController extends AbstractController
{
    /**
     * afficher les annonce de l'utilisateur
     * 
     * @Route("/user/annonce", name="userAnnonce")
     *
     * @return void
     */
    public function userAnnonce(ActuRepository $repo_actu){

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/userAnnonce.html.twig', [
            'side_actu' => $actus,
        ]);
    }


    /**
     * ajout annonce
     * 
     * @Route("/user/annonce/create", name="createAnnonce")
     * 
     */
    public function ajout(ActuRepository $repo_actu, Request $req, EntityManagerInterface $manager, AnnonceNotification $notification)
    {

        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            // $notification->notify($annonce);
            $annonce->setStatus(0);
            $annonce->setUser($this->getUser());
            $manager->persist($annonce);
            $manager->flush();
            $images = $req->files->get('photos');
            

            $uploader  = new Uploader();

            $dist = dirname(__DIR__) . '/../public/images/annonce';
            foreach ($images as $image) {
                $uploader::upload_annonce($image, $dist, $annonce, $manager);
            }
            $this->addFlash("success", "l'ajout a bien été effectué ");
            return $this->redirectToRoute("userAnnonce");
        }

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/newAnnonce.html.twig', [
            'side_actu' => $actus,
            'form' => $form->createView()
        ]);
    }

    /**
     * edition d'une annonce
     * 
     * @Route("/user/annonce/{slug}/edit", name="editAnnonce")
     *
     * @param ActuRepository $repo_actu
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @param Annonce $annonce
     * @return void
     */
    public function modif(ActuRepository $repo_actu, Request $req, EntityManagerInterface $manager, Annonce $annonce, AnnonceNotification $notification){

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            // $notification->notify($annonce);
            $annonce->setStatus(0);
            $manager->persist($annonce);
            $manager->flush();
            $images = $req->files->get('photos');
            

            $uploader  = new Uploader();

            $dist = dirname(__DIR__) . '/../public/images/annonce';
            foreach ($images as $image) {
                $uploader::upload_annonce($image, $dist, $annonce, $manager);
            }
            $this->addFlash("success", "la modification a bien été effectué. Votre annonce est de nouveau en attente de confirmation ");
            return $this->redirectToRoute("userAnnonce");
        }

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('annonce/editAnnonce.html.twig',[
            'side_actu' => $actus,
            'form' => $form->createView(),
            'annonce' => $annonce
        ]);
    }


    /**
     * @Route("/user/annonce/{id}", name="supAnnonceUser", methods="delete")
     */
    public function suppression(Annonce $annonce, EntityManagerInterface $manager, Request $req, PhotosRepository $repo, ActuRepository $repo_actu)
    {
        if ($this->isCsrfTokenValid('SUP' . $annonce->getId(), $req->get('_token'))) {
            $images = $repo->findBy(["annonce" => $annonce]);

            $dist = dirname(__DIR__,2) . '/public/images/annonce/';
            foreach ($images as $image) {
                unlink($dist.$image->getSrc());
                $manager->remove($image);
                $manager->flush();
            }

            $manager->remove($annonce);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("userAnnonce");
        }
    }
}
