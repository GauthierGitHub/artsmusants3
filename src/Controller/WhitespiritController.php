<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;

class WhitespiritController extends AbstractController
{
    /**
     * @Route("/whitespirit", name="whitespirit")
     */
    public function index(PaintingsRepository $paintingsRepository)
    {
        return $this->render('whitespirit/index.html.twig', [
            'controller_name' => 'WhitespiritController',
            'current_menu' => 'whitespirit',
            'paintingsWhiteSpirit' => $paintingsRepository->findBy(['category' => 3]),
        ]);
    }
}
