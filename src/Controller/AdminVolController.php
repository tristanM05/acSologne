<?php

namespace App\Controller;

use App\Entity\Vol;
use App\Repository\DateRepository;
use App\Repository\VolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminVolController extends AbstractController
{
    /**
     * @Route("/admin/vol", name="admin_vol")
     */
    public function index(VolRepository $repo)
    {
        $vol = $repo->findBy([], ["createdAt" => "DESC"]);
        return $this->render('admin/vol.html.twig', [
            'vol' => $vol,
        ]);
    }

        
    /**
     * affichage de l'annonce
     * 
     * @Route("/admin/volof/{id}", name="show_vol")
     */
    public function show(Vol $vol)
    {
        return $this->render('admin/vol_show.html.twig',[
            'vol' => $vol
        ]);
    }


        /**
     * suppression de l'annonce
     * 
     * @Route("/admin/vol/{id}", name="supVol", methods="delete")
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
            return $this->redirectToRoute("admin_vol");
        }
    }

    /**
     * validation de l'annonce
     * 
     * @Route("/admin/vol/{id}", name="validVol", methods="valid")
     */
    public function validation(Vol $vol, EntityManagerInterface $manager, Request $req, \Swift_Mailer $mailer)
    {
        if ($this->isCsrfTokenValid('VAL' . $vol->getId(), $req->get('_token'))) {
            //variable mail
            $user = $vol->getuser()->getemail();
            $title = $vol->gettitle();

            $vol->setStatus(1);

            //envoie message
            $message = (new \Swift_Message('Votre annonce a été publiée'))
            ->setFrom('no-reply@ac-sologne.fr')
            ->setTo($user)
            ->setBody(
                "<p>Votre proposition de vol \"<strong>$title</strong>\" sur le site ac-sologne.fr viens d\"être validé. retrouver toutes vos annonces dans votre espace personnel.</p>",
                'text/html'
            );

            //on envoie le mail
            $mailer->send($message);

            $manager->persist($vol);
            $manager->flush();
            $this->addFlash("success", "la validation a bien été éffectuée");
            return $this->redirectToRoute("admin_vol");
        }
    }
}
