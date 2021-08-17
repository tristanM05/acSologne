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

    /**
     * condition générale
     * 
     * @Route("/consent", name="consent")
     *
     * @param ActuRepository $repo
     * @return void
     */
    public function consent(ActuRepository $repo){
        $actus = $repo->findBy([], ["id" => "DESC"], (4));
        return $this->render('consent.html.twig',[
            'side_actu' => $actus
        ]);
    }
}
