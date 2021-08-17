<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Service\Uploader;
use App\Repository\AlbumRepository;
use App\Repository\PhotosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAlbumController extends AbstractController
{
    /**
     * affichage des albums
     * 
     * @Route("/admin/album", name="admin_album")
     */
    public function index(AlbumRepository $repo)
    {
        $album = $repo->findAll();
        return $this->render('admin/album.html.twig', [
            "album" => $album
        ]);
    }

    /**
     * ajout et modif des album
     * 
     * @Route("admin/album/create", name="createAlbum")
     * @Route("admin/album/{id}", name="modifAlbum", methods ="POST|GET")
     *
     * @param Album $album
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function ajoutEtModif(Album $album = null, Request $req, EntityManagerInterface $manager)
    {

        if (!$album) {
            $album = new Album();
        }

        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $modif = $album->getId() !== null;
            $manager->persist($album);
            $manager->flush();
            $images_album = $req->files->get('photos');

            $uploader  = new Uploader();

            $dist = dirname(__DIR__) . '/../public/images/album';
            foreach ($images_album as $image) {
                $uploader::upload_album($image, $dist, $album, $manager);
            }
            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué ");
            return $this->redirectToRoute("admin_album");
        }

        return $this->render('admin/AMAlbum.html.twig', [
            "album" => $album,
            "form" => $form->createView(),
            'edit' => $album->getId() !== null
        ]);
    }

    /**
     * suppression d'un' album
     * 
     * @Route("/admin/album/{id}", name="supAlbum", methods="delete")
     */
    public function suppression(Album $album, EntityManagerInterface $manager, Request $req, PhotosRepository $repo)
    {
        if ($this->isCsrfTokenValid('SUP' . $album->getId(), $req->get('_token'))) {
            $images = $repo->findBy(["album" => $album]);

            $dist = dirname(__DIR__, 2) . '/public/images/album/';
            foreach ($images as $image) {
                unlink($dist . $image->getSrc());
                $manager->remove($image);
                $manager->flush();
            }
            $manager->remove($album);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("admin_album");
        }
    }
    
    /**
     * @Route("/admin/deleteImg/{id}/{photo}", name="supImg")
     */
    public function deleteImg(Album $album, $photo, PhotosRepository $photosRepository, EntityManagerInterface $manager)
    {
        $image = $photosRepository->find($photo);
        $album->removeImage($image);
        $manager->persist($album);
        $manager->flush();
        $dist = dirname(__DIR__, 2) . '/public/images/album/';
        unlink($dist . $image->getSrc());
        return $this->json(['done' => true], 200);
    }
}
