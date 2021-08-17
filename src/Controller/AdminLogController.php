<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminLogController extends AbstractController
{
    /**
     * log de l'admin
     * 
     * @Route("/admin/log", name="admin_log")
     */
    public function login(AuthenticationUtils $outils)
    {
        $erreur = $outils->getLastAuthenticationError();
        $identifiant = $outils->getLastUsername();

        return $this->render('admin/login.html.twig', [
            'erreur' => $erreur !== null,
            'identifiant' => $identifiant
        ]);
        return $this->redirectToRoute('admin_machines');
    }

    /**
     * permet la deconnexion
     *
     * @Route("/admin/logout", name="admin_logout")
     * @return void
     */
    public function logout(){

    }
}
