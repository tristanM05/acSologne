<?php

namespace App\Service;

use App\Entity\Annonce;
use Twig\Environment;

class AnnonceNotification
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    public function notify(Annonce $annonce)
    {
        $message = (new \Swift_Message('nouvelle annonce en attente de confirmation'))
            ->setFrom('no-reply@ac-sologne.fr')
            ->setTo('contact@mail.fr')
            ->setBody($this->renderer->render('emails/annonce.html.twig', [
                'annonce' => $annonce
            ]), 'text/html');
        $this->mailer->send($message);
    }
}