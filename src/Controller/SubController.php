<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubController extends AbstractController
{
    #[Route('/sub', name: 'sub')]
    public function index(): Response
    {
        return $this->render('sub/index.html.twig', [
            'controller_name' => 'SubController',
        ]);
    }

    #[Route('/subscrition', name: 'subscription')]
    public function subscription(): Response
    {
        return $this->render('sub/sub.html.twig', [
            'controller_name' => 'SubController',
        ]);
    }

}



