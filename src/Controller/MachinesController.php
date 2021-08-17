<?php

namespace App\Controller;

use App\Entity\Machines;
use App\Repository\ActuRepository;
use App\Repository\MachinesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MachinesController extends AbstractController
{
    /**
     * @Route("/machines/{cat}", name="section_moteur")
     */
    public function index(CategoriesRepository $repo, $cat, ActuRepository $repo_actu)
    {
        $category = $repo->findOneBy(['libelle' => $cat]);
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('machines/machine.html.twig', [
            'category' => $category,
            'side_actu' => $actus
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/machine/{slug}", name="machine_show")
     *
     * @param Actu $actu
     * @return void
     */
    public function show(Machines $machine, ActuRepository $repo_actu)
    {

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('machines/machine_show.html.twig', [
            "machine" => $machine,
            'side_actu' => $actus
        ]);
    }
    /**
     * @Route("/pdf/{cat}", name="pdf_view")
     */
    public function pdf(CategoriesRepository $repo, $cat)
    {
        $baseUrl = 'http://127.0.0.1:8888';
        $category = $repo->findOneBy(['libelle' => $cat]);
        $url = $baseUrl.'/images/pdf/' . $category->getTarifs();
        return $this->redirect($url);
    }
}
