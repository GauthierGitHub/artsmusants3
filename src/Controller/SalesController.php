<?php

namespace App\Controller;

use App\Entity\Sales;
use App\Form\SalesType;
use App\Repository\SalesRepository;
use App\Repository\PaintingsRepository;
use App\Repository\CustomersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/sales")
 */
class SalesController extends AbstractController
{
    /**
     * @Route("/", name="sales_index", methods={"GET"})
     */
    public function index(SalesRepository $salesRepository): Response
    {
        return $this->render('sales/index.html.twig', [
            'sales' => $salesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sales_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sale = new Sales();
        $form = $this->createForm(SalesType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sale);
            $entityManager->flush();

            return $this->redirectToRoute('sales_index');
        }

        return $this->render('sales/new.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_show", methods={"GET"})
     */
    public function show(Sales $sale): Response
    {
        return $this->render('sales/show.html.twig', [
            'sale' => $sale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sales_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sales $sale): Response
    {
        $form = $this->createForm(SalesType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sales_index', [
                'id' => $sale->getId(),
            ]);
        }

        return $this->render('sales/edit.html.twig', [
            'sale' => $sale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sales_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sales $sale): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sale->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sales_index');
    }


    /**
     * @Route("/checkout", name="sales_checkout", methods={"GET","POST"})
     */
    public function checkout(Request $request, SalesRepository $salesRepository, $painting, $customer): Response
    {
        //check if painting is already sale
        $painting_id = $painting->getId();
        $painting_saled = $salesRepository->findBy(['painting' => $painting_id]);

        if (!empty($painting_saled)) {
            return $this->render('orders/notavaible.html.twig');
        } else {
            //customer and sale are recorded. Sale is recorded canceled and not canceled before payment;
            $sale = new Sales;
            $sale->setCustomer($customer)
                ->setPainting($painting)
                ->setDate(new \DateTime())
                ->setCanceled(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sale);
            try {
                $entityManager->flush();

                return $this->render('orders/checkout.html.twig', [
                    'painting' => $painting,
                    'customer' => $customer,
                    'sale_id' => $sale->getId(),
                ]);
            } catch (\Doctrine\DBAL\DBALException $error) {
                return $this->render('orders/notavaible.html.twig');
            }
        }
    }
}
