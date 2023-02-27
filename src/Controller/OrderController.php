<?php

namespace App\Controller;

use App\Entity\FlightOrder;
use App\Form\FlightFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public const DISCOUNT_TYPES = [
        'Student' => 10,
        'Senior' => 10,
        'Coupon' => 25,
        'None' => 0,
    ];

    public const DESTINATION_TYPES = [
        'Berlin' => 500,
        'Paris' => 1000,
        'London' => 700,
        'New York' => 10000,
        'New Delhi' => 25000,
    ];

    #[Route('/done', name: 'flight-review', methods: ['GET'])]
    public function show(Request $request): Response
    {
        $firstName = $request->query->get('firstName');
        $lastName = $request->query->get('lastName');
        $email = $request->query->get('email');
        $destination = $request->query->get('destination');
        $fullPrice = OrderController::DESTINATION_TYPES[$destination];
        $discountType = $request->query->get('discount');
        $discount = OrderController::DISCOUNT_TYPES[$discountType];
        $isEU = $fullPrice < 10000;

        // Render Page
        return $this->render('review.html.twig', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'destination' => $destination,
            'isEU' => $isEU,
            'fullPrice' => $fullPrice,
            'discountType' => $discountType,
            'discount' => $discount,
            'finalPrice' => $fullPrice * ($discount / 100),
        ]);
    }

    #[Route('/', name: 'flight-order', methods: ['GET', 'POST'])]
    public function create(Request $request, FlightOrder $flightOrder = null): Response
    {

        // Create Form
        $flightOrder ??= new FlightOrder(null);
        $form = $this->createForm(FlightFormType::class, $flightOrder);

        // Handle Request
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $flightOrder

            return $this->redirectToRoute('flight-review', [
                'firstName' => $flightOrder->getFirstName(),
                'lastName' => $flightOrder->getLastName(),
                'email' => $flightOrder->getEmail(),
                //'birthDate' => $flightOrder->getBirthDate(),
                'destination' => $flightOrder->getDestination(),
                'discount' => $flightOrder->getDiscount(),
            ]);
        }
        
        // Render Page
        return $this->render('index.html.twig', [
            'controller_name' => 'OrderController',
            'form' => $form->createView(),
        ]);
    }
}
