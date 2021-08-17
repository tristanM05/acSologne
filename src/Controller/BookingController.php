<?php

namespace App\Controller;

use App\Entity\Date;
use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\DateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * reservation de l'annonce
     * 
     * @Route("/{id}/book", name="validBook", methods="valid")
     */
    public function Booking(Date $date, EntityManagerInterface $manager, Request $req, \Swift_Mailer $mailer)
    {
        if ($this->isCsrfTokenValid('VAL' . $date->getId(), $req->get('_token'))) {

            $book = new Booking();

            
            $book->setBooker($this->getUser());
            $book->setDate($date);

            //variable mail
            $mailAuthor = $date->getvol()->getuser()->getemail() ;
            $bookerNom = $this->getUser()->getlastname();
            $bookerPrenom = $this->getUser()->getfirstname();
            $thisVol = $date->getvol()->gettitle();

            //envoie message
            $message = (new \Swift_Message('Nouvelle demmande de réservation'))
            ->setFrom('no-reply@ac-sologne.fr')
            ->setTo($mailAuthor)
            ->setBody(
                "<p><strong>$bookerNom $bookerPrenom</strong> viens de faire une demande de réservation de vol pour l'annonce <strong>$thisVol</strong> retrouver ca réservation dans votre espace personnel pour la validation.</p>",
                'text/html'
            );

             //on envoie le mail
            $mailer->send($message);
            $manager->persist($book);
            $manager->flush();
            $this->addFlash("success", "la réservation a bien été éffectuée. L'hôte doit maintenant la confirmer, un email de confirmation vous sera envoyé");
            return $this->redirectToRoute("vol");
        }
    }

    /**
     * validation du booking par l'hote
     * 
     * @Route("/{id}/book/valid", name="validBookUser", methods="valid")
     */
    public function validBook(Booking $book, EntityManagerInterface $manager, Request $req, \Swift_Mailer $mailer)
    {
        if ($this->isCsrfTokenValid('VAL' . $book->getId(), $req->get('_token'))) {

            $nbPlace = $book->getdate()->getnbPlace();

            $book->setstatus(1);
            $book->getdate()->setnbPlace($nbPlace -1);

            //variable mail
            $mailBooker = $book->getbooker()->getemail();
            $thisVol = $book->getdate()->getvol()->gettitle();

            //envoie message
            $message = (new \Swift_Message('Validation de votre réservation de vol'))
            ->setFrom('no-reply@ac-sologne.fr')
            ->setTo($mailBooker)
            ->setBody(
                "<p>Votre réservation pour le l'annonce de vol <strong>$thisVol</strong> viens d\'être accepté. Rtetrouver toute vos réservations dans votre espace personnel</p>",
                'text/html'
            );

             //on envoie le mail
            $mailer->send($message);
            $manager->persist($book);
            $manager->flush();
            $this->addFlash("success", "la réservation a bien été accepté");
            return $this->redirectToRoute("user_vol");
        }
    }

    /**
     * suppression du booking
     * 
     * @Route("/{id}/book/delete", name="supBookUser", methods="delete")
     */
    public function suppression(Booking $book, EntityManagerInterface $manager, Request $req)
    {
        if ($this->isCsrfTokenValid('SUP' . $book->getId(), $req->get('_token'))) {

            $nbPlace = $book->getdate()->getnbPlace();

            $book->getdate()->setnbPlace($nbPlace +1);
            $manager->remove($book);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("user_vol");
        }
    }

        /**
     * suppression du booking
     * 
     * @Route("/{id}/book/delete2", name="supBookUser2", methods="delete")
     */
    public function suppression2(Booking $book, EntityManagerInterface $manager, Request $req,  \Swift_Mailer $mailer)
    {
        if ($this->isCsrfTokenValid('SUP' . $book->getId(), $req->get('_token'))) {

            //variable mail
            $mailBooker = $book->getbooker()->getemail();
            $thisVol = $book->getdate()->getvol()->gettitle();

            //envoie message
            $message = (new \Swift_Message('Refus de votre réservation de vol'))
            ->setFrom('no-reply@ac-sologne.fr')
            ->setTo($mailBooker)
            ->setBody(
                "<p>Votre réservation pour le l'annonce de vol <strong>$thisVol</strong> a été refusé. Rtetrouver toute vos réservations dans votre espace personnel</p>",
                'text/html'
            );

             //on envoie le mail
            $mailer->send($message);
            $manager->remove($book);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("user_vol");
        }
    }

}