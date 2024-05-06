<?php

namespace App\Controller;

use App\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\RecordService;
use App\Service\CartItemService;
use App\Entity\Record;
use Doctrine\ORM\Mapping\Id;

#[Route('/homepage')]
class HomepageController extends AbstractController
{
    private $recordService;
    private $cartItemService;

    public function __construct(RecordService $recordService, CartItemService $cartItemService)
    {
        $this->recordService = $recordService;
        $this->cartItemService = $cartItemService;
    }

    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            "featuredRecord" => $this->recordService->getFeaturedRecord(),
            "recordList" => $this->recordService->getAllRecords(),
        ]);
    }

    #[Route('/to_cart/{id}', name: 'add_to_cart', methods: ['POST'])]
    public function toCart(Record $record): Response
    {
        if($this->isGranted("IS_AUTHENTICATED"))
        {
            $this->cartItemService->addToCart($record, 1);
            return $this->redirectToRoute('app_checkout');
        }

        return $this->redirectToRoute("app_login");
    }
}