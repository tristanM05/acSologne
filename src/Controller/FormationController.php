<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\ActuRepository;
use App\Repository\CategoriesRepository;
use App\Repository\FormationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{

    /**
     * toutes les formations
     * 
     * @Route("/les_formation", name="allFormation")
     *
     * @param FormationRepository $repo
     * @param ActuRepository $repo_actu
     * @param CategoriesRepository $repo_cat
     * @return void
     */
    public function allFormation(FormationRepository $repo, ActuRepository $repo_actu, CategoriesRepository $repo_cat){

        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        $formation = $repo->findBy([], ["id" => "DESC"]);
        return $this->render('formation/allFormation.html.twig', [
            'formation' => $formation,
            'side_actu' => $actus
        ]);
    }

    /**
     * show formation
     * 
     * @Route("les_formation/{slug}", name="formation_show")
     *
     * @param FormationRepository $repo
     * @param ActuRepository $repo_actu
     * @return void
     */
    public function show(FormationRepository $repo, ActuRepository $repo_actu, Formation $formation){
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        $formation2 = $repo->findAll();
        return $this->render('formation/formation_show.html.twig', [
            'formation' => $formation,
            'other_formation' => $formation2,
            'side_actu' => $actus
        ]);

    }


    /**
     * formation par catégorie
     * 
     * @Route("/formation/{cat}", name="formation")
     */
    public function index(CategoriesRepository $repo, $cat, ActuRepository $repo_actu){

        $category = $repo->findOneBy(['libelle' => $cat]);
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('formation/index.html.twig', [
            'category' => $category,
            'side_actu' => $actus
        ]);
    }

    /**
     * detail formation
     * 
     * @Route("/formation/{cat}/{slug}", name="formation_detail")
     *
     * @param ActuRepository $repo_actu
     * @param Formation $formation
     * @return void
     */
    public function detail(ActuRepository $repo_actu, Formation $formation, CategoriesRepository $repo, $cat){
        $actus = $repo_actu->findBy([], ["id" => "DESC"], (4));
        return $this->render('formation/formation_detail.html.twig', [
            'formation' => $formation,
            'side_actu' => $actus
        ]);
    }
}
