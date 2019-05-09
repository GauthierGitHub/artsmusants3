<?php

namespace App\Controller;

use App\Entity\Bookings;
use App\Form\BookingsType;
use App\Repository\BookingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Proxies\__CG__\App\Entity\Paintings;
use Proxies\__CG__\App\Entity\Customers;

/**
 * @Route("/bookings")
 */
class BookingsController extends AbstractController
{
    /**
     * @Route("/", name="bookings_index", methods={"GET"})
     */
    public function index(BookingsRepository $bookingsRepository): Response
    {
        return $this->render('bookings/index.html.twig', [
            'bookings' => $bookingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bookings_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Bookings();
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('bookings_index');
        }

        return $this->render('bookings/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bookings_show", methods={"GET"})
     */
    public function show(Bookings $booking): Response
    {
        return $this->render('bookings/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bookings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bookings $booking): Response
    {
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bookings_index', [
                'id' => $booking->getId(),
            ]);
        }

        return $this->render('bookings/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bookings_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bookings $booking): Response
    {
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bookings_index');
    }


    /**
     * 
     * CLIENT SIDE 
     * 
     */


    /**
     * @Route("bookingsPublic_new", name="bookingsPublic_new", methods={"GET","POST"})
     */
    public function bookingsPublic_new($painting, $customer, \Swift_Mailer $mailer): Response
    {
        $booking = new Bookings();
        $booking->setPainting($painting);
        $booking->setCustomer($customer);
        $booking->setDate(new \DateTime());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        //confirmation mail
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('artsmusants.com@gmail.com')
            ->setTo($customer->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails.html.twig',
                    ['name' => $customer->getFirstName(),
                    'painting' => $painting->getTitle(),
                    ]
                ),
                'text/html'
            );
        $mailer->send($message);


        return $this->redirectToRoute('home');
    }
}
