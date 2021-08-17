<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SideBarController extends AbstractController
{
    /**
     * @Route("/side/bar", name="side_bar")
     */
    public function indexr(ActuRepository $repo)
    {
        $actus = $repo->findBy([], ["id" => "DESC"], (4));
        return $this->render('partials/sidebar.html.twig', [
            'side_actu' => $actus,
        ]);
    }
}
