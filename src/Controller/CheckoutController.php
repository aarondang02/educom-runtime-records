<?php

namespace App\Controller;

use App\Service\CartItemService;
use App\Service\OrderItemService;
use App\Service\OrderService;

use App\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/checkout')]
class CheckoutController extends AbstractController
{
    private $cartItemService;
    private $orderItemService;
    private $orderService;

    public function __construct(CartItemService $cartItemService, OrderService $orderService, OrderItemService $orderItemService)
    {
        $this->cartItemService = $cartItemService;
        $this->orderItemService = $orderItemService;
        $this->orderService = $orderService;
    }

    #[Route('/', name: 'app_checkout')]
    public function index(): Response
    {
        return $this->render('checkout/index.html.twig', [
            'CartItems' => $this->cartItemService->getCartItems(),
        ]);
    }

    #[Route('/remove/{id}', name: 'app_remove_item', methods: ['POST'])]
    public function removeItem(CartItem $item): Response
    {
        $this->cartItemService->removeCartItem($item);
        return $this->redirectToRoute('app_checkout');
    }

    #[Route('/to-order', name: 'app_to_order', methods: ['POST'])]
    public function toOrder(): Response
    {
        $cartItems = $this->cartItemService->getCartItems();
        $order = $this->orderService->createNewOrder();
        $this->orderItemService->toOrderItems($order);
        return $this->redirectToRoute('app_checkout'); #change later to redirect to orderspage or something
    }
}
