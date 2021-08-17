<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Vol;
use App\Entity\Date;
use App\Form\DateType;
use App\Form\UserVolType;
use App\Repository\ActuRepository;
use App\Repository\DateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserVolController extends AbstractController
{
    /**
     * affichage des proposition de vol de l'utilisateur
     * 
     * @Route("/user/vol", name="user_vol")
     */
    public function index(ActuRepository $repo_actu)
    {
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/userVol.html.twig', [
            'side_actu' => $actus
        ]);
    }


    /**
     * new vol
     * 
     * @Route("/user/vol/create", name="volCreate")
     *
     * @param ActuRepository $repo_actu
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function ajout(ActuRepository $repo_actu, Request $req, EntityManagerInterface $manager, \Swift_Mailer $mailer)
    {
        $vol = new Vol();
        $form = $this->createForm(UserVolType::class, $vol);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($vol->getDates() as $date) {
                $date->setVol($vol);
                $manager->persist($date);
                $vol->addDate($date);
                // dd($vol);
            }
            $vol->setStatus(0);
            $vol->setUser($this->getUser());
            $nom = $this->getUser()->getlastname();
            $prenom = $this->getUser()->getfirstname();

            //envoie message
            $message = (new \Swift_Message('Une nouvelle proposotion de vol viens d\'être postée'))
                ->setFrom('no-reply@ac-sologne.fr')
                ->setTo('contact@ac-sologne.fr')
                ->setBody(
                    "<p><strong>$nom $prenom</strong> viens de posté une nouvelle proposition de vol, cette annonce est disponible dans votre espace administrateur pour la validation.</p>",
                    'text/html'
                );

            //on envoie le mail
            $mailer->send($message);
            $manager->persist($vol);
            $manager->flush();

            $this->addFlash("success", "l'ajout a bien été effectué ");
            return $this->redirectToRoute("user_vol");
        }

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/newVol.html.twig', [
            'side_actu' => $actus,
            'form' => $form->createView()
        ]);
    }

    /**
     * edit vol
     * 
     * @Route("/user/vol/{slug}/edit", name="volEdit")
     *
     * @param ActuRepository $repo_actu
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function modif(ActuRepository $repo_actu, Request $req, EntityManagerInterface $manager, Vol $vol)
    {

        $form = $this->createForm(UserVolType::class, $vol);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($vol->getDates() as $date) {
                $date->setVol($vol);
                $manager->persist($date);
            }
            $vol->setStatus(0);
            $vol->setUser($this->getUser());
            $manager->persist($vol);
            $manager->flush();

            $this->addFlash("success", "le modification a bien été effectué ");
            return $this->redirectToRoute("user_vol");
        }

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/editVol.html.twig', [
            'side_actu' => $actus,
            'form' => $form->createView()
        ]);
    }


    /**
     * suppression de l'annonce
     * 
     * @Route("/user/vol/{id}", name="supVolUser", methods="delete")
     */
    public function suppression(Vol $vol, EntityManagerInterface $manager, Request $req, DateRepository $repo_date)
    {
        if ($this->isCsrfTokenValid('SUP' . $vol->getId(), $req->get('_token'))) {
            $dates = $repo_date->findBy(["vol" => $vol]);

            foreach ($dates as $date) {
                $manager->remove($date);
                $manager->flush();
            }

            $manager->remove($vol);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("user_vol");
        }
    }

    /**
     * detail de l'annonce a partir de la page d'affichage utilisateur
     * 
     * @Route("/user/vol/{slug}", name="vol_showUser")
     *
     * @return void
     */
    public function annonceShow(Vol $vol, ActuRepository $repo_actu)
    {

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('vol/vol_showUser.html.twig', [
            "vol" => $vol,
            'side_actu' => $actus
        ]);
    }
}
