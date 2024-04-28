<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Record;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Status;
use App\Repository\CartItemRepository;
use App\Repository\RecordRepository;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderItemRepository;
use App\Repository\StatusRepository;

use Doctrine\ORM\EntityManagerInterface;

class OrderService{

    /** @var CartItemRepository $cartItemRepository */    
    private $cartItemRepository;
    /** @var RecordRepository $recordRepository */    
    private $recordRepository;
    /** @var UserRepository $userRepository */    
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->cartItemRepository = $entityManager->getRepository(CartItem::class);
        $this->recordRepository = $entityManager->getRepository(Record::class);
        $this->userRepository = $entityManager->getRepository(User::class);
    }

}