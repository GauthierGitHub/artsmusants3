<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paintings;
use App\Repository\PaintingsRepository;
use Symfony\Component\HttpFoundation\Response;


class BlancdeblancController extends AbstractController
{
    /**
     * @Route("/blancdeblanc", name="blancdeblanc")
     */
    public function index(PaintingsRepository $paintingsRepository)
    {
        return $this->render('blancdeblanc/index.html.twig', [
            'controller_name' => 'BlancdeblancController',
            'current_menu' => 'blancdeblanc',
            'paintingsBlancDeBlanc' => $paintingsRepository->findBy(['category' => 1]),
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
