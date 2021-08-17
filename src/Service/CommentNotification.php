<?php

namespace App\Service;

use App\Entity\Comment;
use Twig\Environment;

class CommentNotification
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
    public function notify(Comment $comment)
    {
        $message = (new \Swift_Message('nouveaux commentaire'))
            ->setFrom($comment->getEmail())
            ->setTo('contact@mail.fr')
            ->setBody($this->renderer->render('emails/comment.html.twig', [
                'comment' => $comment
            ]), 'text/html');
        $this->mailer->send($message);
    }
}