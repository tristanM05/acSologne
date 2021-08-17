<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\ActuRepository;
use App\Repository\AlbumRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GalerieController extends AbstractController
{
    /**
     * @Route("/galerie", name="galerie")
     */
    public function index(AlbumRepository $repo, ActuRepository $repo_actu)
    {
        $album = $repo->findBy([], ["createdAt" => "DESC"]);
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('galerie/index.html.twig', [
            'album' => $album,
            'side_actu' => $actus
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/album/{slug}", name="album_show")
     *
     */
    public function show(Album $album, ActuRepository $repo_actu){
        
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('galerie/album_show.html.twig', [
            'album' => $album,
            'side_actu' => $actus
        ]);

    }

}
