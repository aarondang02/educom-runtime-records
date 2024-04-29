<?php

namespace App\Controller;

use App\Service\CartItemService;
use App\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/checkout')]
class CheckoutController extends AbstractController
{
    private $cartItemService;
    
    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
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

}
