<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaintingsRepository;
use Doctrine\Common\Persistence\ObjectManager;

class BlancdeblancController extends AbstractController
{
    /**
     * @Route("/blancdeblanc", name="blancdeblanc")
     */
    public function index()
    {
        return $this->render('blancdeblanc/index.html.twig', [
            'controller_name' => 'BlancdeblancController',
            'current_menu' => 'blancdeblanc',
        ]);
    }

    /**
     * @var PaintingsRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PaintingsRepository $repository, ObjectManager $em)
    {
        //exemple d'injection de dépendances
        $this->repository = $repository;
        $this->em = $em;
    }
}
