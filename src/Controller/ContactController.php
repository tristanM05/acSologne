<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ActuRepository;
use App\Service\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(ActuRepository $repo_actu, Request $req, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute("contact");
        }

        $actus = $repo_actu->findBy([],["id" => "DESC"], (4));
        return $this->render('contact/index.html.twig', [
            'side_actu' => $actus,
            'form' => $form->createView()
        ]);
    }
    
}
