<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * affiche tout les comment
     * 
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(CommentRepository $repo)
    {
        $comment = $repo->findBy([], ["created_at" => "DESC"]);
        return $this->render('admin/comment.html.twig', [
            'comment' => $comment
        ]);
    }

    /**
     * affiche le comment
     * 
     * @Route("/admin/commentof/{id}", name="comment_show")
     */
    public function show(Comment $comment)
    {
        return $this->render('admin/comment_show.html.twig',[
            'comment' => $comment
        ]);
    }

    /**
     * suppression
     * 
     * @Route("/admin/comment/{id}", name="supComment", methods="delete")
     */
    public function suppression(Comment $comment, EntityManagerInterface $manager, Request $req)
    {
        if ($this->isCsrfTokenValid('SUP' . $comment->getId(), $req->get('_token'))) {

            $manager->remove($comment);
            $manager->flush();
            $this->addFlash("success", "la suppression a bien été éffectuée");
            return $this->redirectToRoute("admin_comment");
        }
    }

    /**
     * validation
     * 
     * @Route("/admin/comment/{id}", name="validComment", methods="valid")
     */
    public function validation(Comment $comment, EntityManagerInterface $manager, Request $req)
    {
        if ($this->isCsrfTokenValid('VAL' . $comment->getId(), $req->get('_token'))) {

            $comment->setStatus(1);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash("success", "la validation a bien été éffectuée");
            return $this->redirectToRoute("admin_comment");
        }
    }
}
