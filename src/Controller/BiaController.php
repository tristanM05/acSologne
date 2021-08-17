<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BiaController extends AbstractController
{
    /**
     * @Route("/bia", name="bia")
     */
    public function index(ActuRepository $repo_actu)
    {
        $actus = $repo_actu->findBy([],["id" => "DESC"], (4));
        return $this->render('club/bia.html.twig', [
            'controller_name' => 'BiaController',
            'side_actu' => $actus
        ]);
    }

}
