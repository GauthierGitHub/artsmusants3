<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Entity\Paintings;
use App\Form\CustomersType;
use App\Repository\CustomersRepository;
use App\Repository\PaintingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/customers")
 */
class CustomersController extends AbstractController
{
    /**
     * @Route("/", name="customers_index", methods={"GET"})
     */
    public function index(CustomersRepository $customersRepository): Response
    {
        return $this->render('customers/index.html.twig', [
            'customers' => $customersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="customers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $customer = new Customers();
        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customers_index');
        }

        return $this->render('customers/new.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customers_show", methods={"GET"})
     */
    public function show(Customers $customer): Response
    {
        return $this->render('customers/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="customers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Customers $customer): Response
    {
        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('customers_index', [
                'id' => $customer->getId(),
            ]);
        }

        return $this->render('customers/edit.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="customers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Customers $customer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('customers_index');
    }

    /**
     * 
     * CLIENT SIDE 
     * 
     */

    /**
     * @Route("/{painting_id}/booking", name="customers_book", methods={"GET","POST"})
     */
    public function book(Request $request, $painting_id, PaintingsRepository $paintingsRepository): Response
    {
        $painting = $paintingsRepository->find($painting_id);

        $customer = new Customers();

        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            $response = $this->forward('App\Controller\BookingsController::bookingsPublic_new', [
                'customer' => $customer,
                'painting' => $painting,
            ]);

            return $response;
        }

        return $this->render('bookandsale/book.html.twig', [
            'painting' => $painting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{painting_id}/buy", name="customers_sale", methods={"GET","POST"})
     */
    public function sale()
    {
        var_dump($_POST);
    }
}
