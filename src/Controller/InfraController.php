<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InfraController extends AbstractController
{
    /**
     * @Route("/infrastructure", name="infrastructure")
     */
    public function index()
    {
        return $this->render('club/infra.html.twig', [
            'controller_name' => 'InfraController',
        ]);
    }

    public function sideBar(ActuRepository $repo, $limit = 4)
    {
        $actus = $repo->findBy([], [$limit], ["id" => "DESC"]);
        return $this->render('partials/sidebar.html.twig', [
            'other_actu' => $actus,
        ]);
    }
}
