<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Record;
use App\Entity\User;
use App\Entity\CartItem;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RecordRepository;
use App\Repository\CartItemRepository;
use App\Service\CartItemService;
use Doctrine\ORM\EntityManagerInterface;


class TestController extends AbstractController
{
    private $cartItemService;

    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        $data = $this->cartItemService->getCartItems();
        dd($data);
    }
}
