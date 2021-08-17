<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AbstractController
{
    /**
     * affiche tout les membres
     * 
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $repo)
    {
        $user = $repo->findAll();
        return $this->render('admin/user.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * ajout d'un nouveaux membre
     * 
     * @Route("/admin/new_user", name="createUser")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return void
     */
    public function newMenber(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request); //gère la requete

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé !"
            );

            return $this->redirectToRoute('admin_user');

        }

        return $this->render('admin/createUser.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * suppression
     * 
     * @Route("/admin/user/{id}", name="supUser", methods="delete")
     */
    public function suppression(User $user, EntityManagerInterface $manager, Request $req)
    {
        if ($this->isCsrfTokenValid('SUP' . $user->getId(), $req->get('_token'))) {

            $manager->remove($user);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("admin_user");
        }
    }
}
