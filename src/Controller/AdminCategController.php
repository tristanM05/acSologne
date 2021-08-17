<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategController extends AbstractController
{
    /**
     * @Route("/admin/categ", name="admin_categ")
     */
    public function index(CategoriesRepository $repo)
    {
        $categ = $repo->findAll();
        return $this->render('admin/categories.html.twig',[
            "categ" => $categ
        ]);
    }

    /**
     * modif de categorie
     * 
     * @Route("admin/categ/{id}", name="modifCateg", methods ="POST|GET")
     *
     * @param Categories $categ
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function ajoutEtModif(Categories $categ, Request $req, EntityManagerInterface $manager){

        $form = $this->createForm(CategType::class, $categ);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $categ->getId() !== null;
            $manager->persist($categ);
            $manager->flush();
            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué " );
            return $this->redirectToRoute("admin_categ");
        }

        return $this->render('admin/AMCateg.html.twig',[
            "categ" => $categ,
            "form" => $form->createView(),
            "isModification" => $categ->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/categ/{id}", name="supCateg", methods="delete")
     */
    public function suppression(Categories $categ, EntityManagerInterface $manager, Request $req)
    {
        if($this->isCsrfTokenValid('SUP'.$categ->getId(), $req->get('_token'))){
            $manager->remove($categ);
            $manager->flush();
            $this->addFlash("success","la suppression a bien été éffectuée" );
            return $this->redirectToRoute("admin_categ");
        }
    }
}