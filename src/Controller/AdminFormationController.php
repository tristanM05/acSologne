<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\PhotosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Uploader;

class AdminFormationController extends AbstractController
{
    /**
     * affiche les formations
     * 
     * @Route("/admin/formation", name="admin_formation")
     */
    public function index(FormationRepository $repo)
    {
        $formation = $repo->findAll();
        return $this->render('admin/formation.html.twig', [
            'formations' => $formation
        ]);
    }

    /**
     * Ajout et modif formation
     *
     * @Route("admin/formation/create", name="createFormation")
     * @Route("admin/formation/{id}", name="modifFormation", methods ="POST|GET")
     * 
     * @param Formation $formation
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function ajoutEtModif(Formation $formation = null, Request $req, EntityManagerInterface $manager){

        if (!$formation) {
            $formation = new Formation();
            $i = 1;
        }

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $modif = $formation->getId() !== null;
            $manager->persist($formation);
            $manager->flush();
            $images = $req->files->get('photos');

            $uploader  = new Uploader();

            $dist = dirname(__DIR__) . '/../public/images/formation';
            foreach ($images as $image) {
                $uploader::upload_formation($image, $dist, $formation, $manager);
            }

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_formation");
    }

    return $this->render('admin/AMFormation.html.twig', [
        "formation" => $formation,
        "form" => $form->createView(),
        'edit' => $formation->getId() !== null
    ]);

    }

    /**
     * suppression
     * 
     * @Route("/admin/formation/{id}", name="supFormation", methods="delete")
     */
    public function suppression(Formation $formation, EntityManagerInterface $manager, Request $req, PhotosRepository $repo)
    {
        if ($this->isCsrfTokenValid('SUP' . $formation->getId(), $req->get('_token'))) {
            $images = $repo->findBy(["formation" => $formation]);

            $dist = dirname(__DIR__,2) . '/public/images/formation/';
            foreach ($images as $image) {
                unlink($dist.$image->getSrc());
                $manager->remove($image);
                $manager->flush();
            }

            $manager->remove($formation);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("admin_formation");
        }
    }

    /**
     * @Route("/admin/deleteImgForm/{id}/{photo}", name="supImgFormation")
     */
    public function deleteImg(Formation $formation, $photo, PhotosRepository $photosRepository, EntityManagerInterface $manager)
    {
        $image = $photosRepository->find($photo);
        $formation->removeImage($image);
        $manager->persist($formation);
        $manager->flush();
        $dist = dirname(__DIR__, 2) . '/public/images/formation/';
        unlink($dist . $image->getSrc());
        return $this->json(['done' => true], 200);
    }

}
