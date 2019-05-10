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
 * @Route("/sales")
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
    public function checkout(Request $request, $painting, $customer): Response
    {

        //customer and sale are recorded. Sale is recorded canceled and not canceled before payment;
        $sale = new Sales;
        $sale->setCustomer($customer)
            ->setPainting($painting)
            ->setDate(new \DateTime())
            ->setCanceled(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($sale);
        $entityManager->flush();

        return $this->render('orders/checkout.html.twig', [
            'painting' => $painting,
            'customer' => $customer,
            'sale_id' => $sale->getId(),
        ]);
    }

    /**
     * @Route("/stripe", name="sales_stripe", methods={"POST"})
     */
    public function stripe(\Swift_Mailer $mailer, PaintingsRepository $paintingsRepository, CustomersRepository $customersRepository, SalesRepository $salesRepository): Response
    {

        $painting = $paintingsRepository->find($_POST['painting_id']);
        $customer = $customersRepository->find($_POST['customer_id']);
        $sale = $salesRepository->find($_POST['sale_id']);

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        try {
            \Stripe\Stripe::setApiKey('sk_test_7DkjJe8fFYBFUt9hAdc7JqAN00V29BgrCg');
            $charge = \Stripe\Charge::create([
                'amount' => $painting->getPrice() * 100,//amout in cents
                'currency' => 'eur',
                'source' => $_POST['stripeToken'],
                'statement_descriptor' => 'artsmusants',
                'receipt_email' => $customer->getEmail(),
            ]);

            //confirmation mail
            $message = (new \Swift_Message('Arts Musants - Booking'))
                ->setFrom('artsmusants.com@gmail.com')
                ->setTo($customer->getEmail())
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'emails.html.twig',
                        [
                            'name' => $customer->getFirstName(),
                            'painting' => $painting->getTitle(),
                            'action' => 'buy',
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $sale->setCanceled(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sale);
            $entityManager->flush();

            return $this->render('orders/success.html.twig', [
                'painting' => $painting,
                'customer' => $customer,
            ]);
        } catch (Exception $error) {

            return $this->render('orders/error.html.twig');
        }
    }
}
