<?php

namespace App\Controller;

use App\Entity\Paintings;
use App\Form\PaintingsType;
use App\Repository\PaintingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paintings")
 */
class PaintingsController extends AbstractController
{
    /**
     * @Route("/", name="paintings_index", methods={"GET"})
     */
    public function index(PaintingsRepository $paintingsRepository): Response
    {
        return $this->render('paintings/index.html.twig', [
            'paintings' => $paintingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="paintings_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $painting = new Paintings();
        $form = $this->createForm(PaintingsType::class, $painting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($painting);
            $entityManager->flush();

            return $this->redirectToRoute('paintings_index');
        }

        return $this->render('paintings/new.html.twig', [
            'painting' => $painting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paintings_show", methods={"GET"})
     */
    public function show(Paintings $painting): Response
    {
        return $this->render('paintings/show.html.twig', [
            'painting' => $painting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paintings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paintings $painting): Response
    {
        $form = $this->createForm(PaintingsType::class, $painting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paintings_index', [
                'id' => $painting->getId(),
            ]);
        }

        return $this->render('paintings/edit.html.twig', [
            'painting' => $painting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paintings_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paintings $painting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$painting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($painting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('paintings_index');
    }
}
