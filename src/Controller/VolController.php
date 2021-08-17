<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VolController extends AbstractController
{
    /**
     * @Route("/decouvrir_le_vol", name="decouvrir_le_vol")
     */
    public function index(ActuRepository $repo_actu)
    {
        $actus = $repo_actu->findBy([],["id" => "DESC"], (4));
        return $this->render('club/vol.html.twig', [
            'side_actu' => $actus
        ]);
    }
}



