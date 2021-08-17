<?php

namespace App\Controller;

use App\Entity\Machines;
use App\Form\MachineType;
use App\Service\Uploader;
use App\Repository\MachinesRepository;
use App\Repository\PhotosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMachinesController extends AbstractController
{
    /**
     * affiche toute les machines
     * 
     * @Route("/admin/machines", name="admin_machines")
     */
    public function index(MachinesRepository $repo)
    {
        $machine = $repo->findAll();
        return $this->render('admin/machines.html.twig',[
            'machine' => $machine
        ]);
    }

    /**
     * modif et ajout machine
     * 
     *  @Route("/admin/machines/create", name="createMachine")
     * @Route("/admin/machines/{id}", name="modifMachine", methods="GET|POST")
     *
     * @param Machines $machine
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function AjoutEtModif(Machines $machine = null, PhotosRepository $repo, Request $req, EntityManagerInterface $manager){
        if(!$machine){
            $machine = new Machines();
        }
        $form = $this->createForm(MachineType::class,$machine);
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $modif = $machine->getId() !== null;
            $manager->persist($machine);
            $manager->flush();
            $images_machine = $req->files->get('photos');

            $uploader  = new Uploader();

            $dist = dirname(__DIR__) . '/../public/images/machines';
            foreach ($images_machine as $image) {
                $uploader::upload_machine($image, $dist, $machine, $manager);
            }

            $this->addFlash("success", ($modif) ? "la modification a bien été éffectuée" : "l'ajout a bien été effectué " );
            return $this->redirectToRoute("admin_machines");
        }

        return $this->render('admin/AMMachine.html.twig',[
            "machine" => $machine,
            "form" => $form->createView(),
            'edit' => $machine->getId() !== null
        ]);
    }

    /**
     * suppression
     * 
     * @Route("/admin/machines/{id}", name="supMachine", methods="delete")
     */
    public function suppression(Machines $machine, EntityManagerInterface $manager, Request $req, PhotosRepository $repo)
    {
        if($this->isCsrfTokenValid('SUP'.$machine->getId(), $req->get('_token'))){
            $images = $repo->findBy(["machines" => $machine]);

            $dist = dirname(__DIR__,2) . '/public/images/machines/';
            foreach ($images as $image) {
                unlink($dist.$image->getSrc());
                $manager->remove($image);
                $manager->flush();
            }
            $manager->remove($machine);
            $manager->flush();
            $this->addFlash("success","la suppression a bien été éffectuée" );
            return $this->redirectToRoute("admin_machines");
        }
    }

    /**
     * @Route("/admin/deleteImgMachine/{id}/{photo}", name="supImgMachine")
     */
    public function deleteImg(Machines $machine, $photo, PhotosRepository $photosRepository, EntityManagerInterface $manager)
    {
        $image = $photosRepository->find($photo);
        $machine->removeImage($image);
        $manager->persist($machine);
        $manager->flush();
        $dist = dirname(__DIR__, 2) . '/public/images/machines/';
        unlink($dist . $image->getSrc());
        return $this->json(['done' => true], 200);
    }
}
