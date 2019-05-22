<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PaintingsRepository;
use App\Repository\CustomersRepository;
use App\Repository\SalesRepository;
use App\Entity\Customers;
use App\Form\CustomersType;

class OrdersController extends AbstractController
{
    /**
     * @Route("/orders", name="orders")
     */
    public function index()
    {
        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }

    /**
     * @Route("/success", name="success")
     */
    public function success($painting, $name, $action, $email)
    {
        return $this->render('orders/success.html.twig', [
            'controller_name' => 'OrdersController',
            'name' => $name,
            'painting' => $painting,
            'email' => $email,
            'action' => $action,
        ]);
    }


    /**
     * @Route("/error", name="error")
     */
    public function error()
    {
        return $this->render('orders/error.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }

    /**
     * @Route("/{painting_id}/booking", name="book", methods={"GET","POST"})
     */
    public function book(Request $request, $painting_id, PaintingsRepository $paintingsRepository, SalesRepository $salesRepository): Response
    {
        //check if painting is already sale
        $painting_saled = $salesRepository->findBy(['painting' => $painting_id]);

        if (!empty($painting_saled)) {
            return $this->render('orders/notavaible.html.twig');
        } else {
            $painting = $paintingsRepository->find($painting_id);

            $customer = new Customers();

            $form = $this->createForm(CustomersType::class, $customer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();

                $entityManager->persist($customer);
                $entityManager->flush();

                return $this->forward('App\Controller\BookingsController::bookingsPublic_new', [
                    'customer' => $customer,
                    'painting' => $painting,
                ]);
            }

            return $this->render('orders/book.html.twig', [
                'painting' => $painting,
                'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/{painting_id}/buy", name="sale", methods={"GET","POST"})
     */
    public function sale(Request $request, $painting_id, PaintingsRepository $paintingsRepository, SalesRepository $salesRepository): Response
    {
        //customer is recording but sale is canceled if payment is not accepted
        $painting = $paintingsRepository->find($painting_id);

        //check if painting is already sale
        $painting_id = $painting->getId();
        $painting_saled = $salesRepository->findBy(['painting' => $painting_id]);

        if (!empty($painting_saled)) {
            return $this->render('orders/notavaible.html.twig');
        } else {

            $customer = new Customers();

            $form = $this->createForm(CustomersType::class, $customer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($customer);
                $entityManager->flush();

                return $this->forward('App\Controller\SalesController::checkout', [
                    'customer' => $customer,
                    'painting' => $painting,
                ]);
            }

            return $this->render('orders/sale.html.twig', [
                'painting' => $painting,
                'form' => $form->createView(),
            ]);
        }
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
                'amount' => $painting->getPrice() * 100, //amout in cents
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
                'painting' => $painting->getTitle(),
                'name' => $customer->getFirstname(),
                'email' => $customer->getEmail(),
                'action' => 'sale',
            ]);
        } catch (Exception $error) {

            return $this->render('orders/error.html.twig');
        }
    }
}
