<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Paintings;



class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PaintingsRepository $paintingsRepository)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'current_menu' => 'home',
            'paintingsBlancDeBlanc' => $paintingsRepository->findSquareFormat(1),
            'paintingsCouleursEtMatieres' => $paintingsRepository->findSquareFormat(2),
            'paintingsWhiteSpirit' => $paintingsRepository->findSquareFormat(3),
        ]);
    }

    /**
     * @Route("/{id}/show", name="paintings_showOnePublic", methods={"GET"})
     */
    public function showOnePublic(Paintings $painting): Response
    {
        return $this->render('paintings/showOnePublic.html.twig', [
            'painting' => $painting,
        ]);
    }
}
