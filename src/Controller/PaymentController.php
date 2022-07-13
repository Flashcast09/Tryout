<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{

    #[Route('/payment', name: 'payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }


    #[Route('/checkout', name: 'checkout')]
    public function checkout($stripeSK, SessionInterface $sessionPanier, ProductsRepository $productsRepository): Response
    {
        Stripe::setApiKey($stripeSK);
        

        $panier = $sessionPanier->get('panier', []);

        $items = [];
        foreach ($panier as $id => $quantite) {
            $product = $productsRepository->find($id);
            array_push($items, [
                'price_data' => [
                'currency' => 'EUR',
                'product_data' => [                
                    'name' => $product->getName(),
                ],
                'unit_amount' => $product->getPrice() * 100,
                ],
                'quantity' => $quantite,
                
                
            ]);
        }

        $session = Session::create([
            'line_items' => $items,
            // ADRESSE LIVRAISON SETUP STRIPE
            'shipping_address_collection' => [
                'allowed_countries' => ['FR'],
              ],
              'shipping_options' => [
                [
                    // SETUP LES FRAIS DE LIVRAISONS AVEC LA CURRENCY LE PAYS ET LES JOURS OUVRABLES
                  'shipping_rate_data' => [
                    'type' => 'fixed_amount',
                    'fixed_amount' => [
                      'amount' => 10,
                      'currency' => 'EUR',
                    ],
                    'display_name' => 'Frais de livraisons',
                    // Delivers between 5-7 business days
                    'delivery_estimate' => [
                      'minimum' => [
                        'unit' => 'business_day',
                        'value' => 5,
                      ],
                      'maximum' => [
                        'unit' => 'business_day',
                        'value' => 7,
                      ],
                    ]
                  ]
                ],],
              
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', []);
    }


    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}