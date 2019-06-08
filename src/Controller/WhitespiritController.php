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
class WhitespiritController extends AbstractController
{
    /**
     * @Route("/whitespirit", name="whitespirit")
     */
    public function index(PaintingsRepository $paintingsRepository, PaginatorInterface $paginator, Request $request)
    {
        // paginator : https://github.com/KnpLabs/KnpPaginatorBundle
        $query = $paintingsRepository->findCatQuery(3);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),//page number
            12 //limit per page
        );

        return $this->render('whitespirit/index.html.twig', [
            'controller_name' => 'WhitespiritController',
            'current_menu' => 'whitespirit',
            'pagination' => $pagination,
        ]);
    }
}
