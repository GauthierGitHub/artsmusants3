<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;

class CouleursetmatieresController extends AbstractController
{
    /**
     * @Route("/couleursetmatieres", name="couleursetmatieres")
     */
    public function index(PaintingsRepository $paintingsRepository)
    {
        return $this->render('couleursetmatieres/index.html.twig', [
            'controller_name' => 'CouleursetmatieresController',
            'current_menu' => 'couleursetmatieres',
            'paintingsCouleursEtMatieres' => $paintingsRepository->findBy(['category' => 2]),
        ]);
    }
}
