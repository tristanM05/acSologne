<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ActuRepository;
use App\Repository\CommentRepository;
use App\Service\CommentNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{

    /**
     * création d'un commentaire
     * 
     * @Route("/comment", name="comment")
     */
    public function index(ActuRepository $repo, Request $req, CommentNotification $notification, EntityManagerInterface $manager, CommentRepository $repo_comment)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($comment);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute("comment");
        }

        $show_comment = $repo_comment->findBy(["status" => 1], ["created_at" => "DESC"]);
        $actus = $repo->findBy([], ["id" => "DESC"], (4));
        return $this->render('comment/comment.html.twig', [
            'comment' => $show_comment,
            'side_actu' => $actus,
            'form' => $form->createView(),
        ]);
    }
}
