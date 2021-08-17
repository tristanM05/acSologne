<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Form\ActuType;
use App\Repository\ActuRepository;
use App\Repository\PhotosRepository;
use App\Service\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class AdminActuController extends AbstractController
{
    /**
     * affichage de toute les actus
     * 
     * @Route("/admin/actu", name="admin_actu")
     */
    public function index(ActuRepository $repo)
    {
        $actu = $repo->findAll();
        return $this->render('admin/actu.html.twig', [
            "actu" => $actu
        ]);
    }

    /**
     * ajout et modif des actus
     * 
     * @Route("admin/actu/create", name="createActu")
     * @Route("admin/actu/{id}", name="modifActu", methods ="POST|GET")
     *
     * @param Actu $actu
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function ajoutEtModif(Actu $actu = null, Request $req, EntityManagerInterface $manager)
    {

        if (!$actu) {
            $actu = new Actu();
            $i = 1;
        }

        $form = $this->createForm(ActuType::class, $actu);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $modif = $actu->getId() !== null;
            $manager->persist($actu);
            $manager->flush();
            $images = $req->files->get('photos');
            

            $uploader  = new Uploader();

            $dist = dirname(__DIR__) . '/../public/images/actu';
            foreach ($images as $image) {
                $uploader::upload_actu($image, $dist, $actu, $manager);
            }
            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_actu");
        }

        return $this->render('admin/AMActu.html.twig', [
            "actu" => $actu,
            "form" => $form->createView(),
            'edit' => $actu->getId() !== null
        ]);
    }

    /**
     * suppression d'une actu
     * 
     * @Route("/admin/actu/{id}", name="supActu", methods="delete")
     */
    public function suppression(Actu $actu, EntityManagerInterface $manager, Request $req, PhotosRepository $repo)
    {
        if ($this->isCsrfTokenValid('SUP' . $actu->getId(), $req->get('_token'))) {
            $images = $repo->findBy(["actu" => $actu]);

            $dist = dirname(__DIR__,2) . '/public/images/actu/';
            foreach ($images as $image) {
                unlink($dist.$image->getSrc());
                $manager->remove($image);
                $manager->flush();
            }

            $manager->remove($actu);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("admin_actu");
        }
    }

    /**
     * @Route("/admin/deleteImgActu/{id}/{photo}", name="supImgActu")
     */
    public function deleteImg(Actu $actu, $photo, PhotosRepository $photosRepository, EntityManagerInterface $manager)
    {
        $image = $photosRepository->find($photo);
        $actu->removeImage($image);
        $manager->persist($actu);
        $manager->flush();
        $dist = dirname(__DIR__, 2) . '/public/images/actu/';
        unlink($dist . $image->getSrc());
        return $this->json(['done' => true], 200);
    }
}
