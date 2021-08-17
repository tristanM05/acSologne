<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBookingController extends AbstractController
{
    /**
     * @Route("/user/booking", name="user_booking")
     */
    public function bookUser(ActuRepository $repo_actu){

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/bookUser.html.twig', [
            'side_actu' => $actus,
        ]);
    }
}
