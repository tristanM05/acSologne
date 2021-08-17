<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Entity\Date;
use App\Entity\Booking;
use App\Repository\VolRepository;
use App\Repository\ActuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VolController extends AbstractController
{
    /**
     * @Route("/vol", name="vol")
     */
    public function index(VolRepository $repo_vol, ActuRepository $repo_actu)
    {
        $show_vol = $repo_vol->findBy(["status" => 1], ["createdAt" => "DESC"]);
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/index.html.twig', [
            'vol' => $show_vol,
            'side_actu' => $actus,
        ]);
    }

    /**
     * detail de l'annonce a partir de la page d'affichage général
     * 
     * @Route("/vol/{slug}", name="vol_show")
     *
     * @return void
     */
    public function annonceShow(Vol $vol, ActuRepository $repo_actu){

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/vol_show.html.twig', [
            "vol" => $vol,
            'side_actu' => $actus
        ]);
    }
}
