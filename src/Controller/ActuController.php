<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Repository\ActuRepository;
use App\Repository\PhotosRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActuController extends AbstractController
{
    /**
     * affichage principale des actu
     * 
     * @Route("/actu/", name="actu")
     */
    public function index(ActuRepository $repo)
    {
        $actus = $repo->findBy([], ["id" => "DESC"]);
        $actus2 = $repo->findBy([], ["id" => "DESC"], (4));
        return $this->render('club/actu.html.twig',[
            "actus" => $actus,
            'side_actu' => $actus2
        ]);
    }

    /**
     * affichage d'une actu
     * 
     * @Route("/actu/{slug}", name="actu_show")
     *
     * @param Actu $actu
     * @return void
     */
    public function show(Actu $actu, ActuRepository $repo){
        
        $actus = $repo->findBy([], ["id" => "DESC"]);
        $actus2 = $repo->findBy([], ["id" => "DESC"], (4));
        return $this->render('club/actu_show.html.twig', [
            'actu' => $actu,
            'other_actu' => $actus,
            'side_actu' => $actus2
        ]);

    }
}

