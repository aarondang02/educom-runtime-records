<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecordpageController extends AbstractController
{
    #[Route('/recordpage', name: 'app_recordpage')]
    public function index(): Response
    {
        return $this->render('recordpage/index.html.twig', [
            'controller_name' => 'RecordpageController',
        ]);
    }
}
