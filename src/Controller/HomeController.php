<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Paintings;

/**
 * @Route("{_locale}")
 */
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

    /**
     * @Route("/artisticApproach", name="artisticApproach")
     */
    public function artisticApproach(): Response
    {
        return $this->render('home/artisticApproach.html.twig', [
            'current_menu' => 'artisticApproach',
        ]);
    }

    /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv(): Response
    {
        return $this->render('home/cgv.html.twig', []);
    }

    /**
     * @Route("/language", name="language")
     */
    public function setLanguage(Request $request)
    {
        dump($_GET);
        $request->setLocale($_GET['language']);
        dump($request->getLocale());
        dump($request);
        dump($_GET['url']);
        return $this->redirect($_GET['url']);
    }
}
