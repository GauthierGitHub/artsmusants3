<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PaintingsRepository $paintingsRepository)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'paintingsBlancDeBlanc' => $paintingsRepository->findBy(['category' => 1]),
            'paintingsCouleursEtMatieres' => $paintingsRepository->findBy(['category' => 2]),
            'paintingsWhiteSpirit' => $paintingsRepository->findBy(['category' => 3]),
        ]);
    }
}
