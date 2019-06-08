<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("{_locale}")
 */
class CouleursetmatieresController extends AbstractController
{
    /**
     * @Route("/couleursetmatieres", name="couleursetmatieres")
     */
    public function index(PaintingsRepository $paintingsRepository, PaginatorInterface $paginator, Request $request)
    {
        // paginator : https://github.com/KnpLabs/KnpPaginatorBundle
        $query = $paintingsRepository->findCatQuery(2);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),//page number
            12 //limit per page
        );

        return $this->render('couleursetmatieres/index.html.twig', [
            'controller_name' => 'CouleursetmatieresController',
            'current_menu' => 'couleursetmatieres',
            'pagination' => $pagination,
        ]);
    }
}
