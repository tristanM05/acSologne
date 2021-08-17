<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ActuRepository $repo_actu)
    {
        $actus = $repo_actu->findBy([],["id" => "DESC"], (4));
        return $this->render('home.html.twig', [
            'side_actu' => $actus
        ]);
    }
}
