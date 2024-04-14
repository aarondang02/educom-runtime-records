<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartpageController extends AbstractController
{
    #[Route('/cartpage', name: 'app_cartpage')]
    public function index(): Response
    {
        return $this->render('cartpage/index.html.twig', [
            'controller_name' => 'CartpageController',
        ]);
    }
}
