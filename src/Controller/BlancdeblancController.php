<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;

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
}
