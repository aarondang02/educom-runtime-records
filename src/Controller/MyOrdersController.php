<?php

namespace App\Controller;

use App\Service\OrderService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/my-orders')]
class MyOrdersController extends AbstractController
{   
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    #[Route('', name: 'app_my_orders')]
    public function index(): Response
    {
        return $this->render('my_orders/index.html.twig', [
            "orderList" => $this->orderService->getOrders(),
        ]);
    }

    #[Route('/detail/{orderNumber}', name: 'app_order_detail')]
    public function detail($orderNumber): Response
    {   
        return $this->render('my_orders/detail.html.twig', [
            "order" => $this->orderService->findByOrderNumber($orderNumber),
        ]);
    }
}
