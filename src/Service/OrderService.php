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
use Error;
use phpDocumentor\Reflection\DocBlock\Description;

class OrderService{

    /** @var CartItemRepository $cartItemRepository */    
    private $cartItemRepository;
    /** @var RecordRepository $recordRepository */    
    private $recordRepository;
    /** @var UserRepository $userRepository */    
    private $userRepository;
    /** @var OrderRepository $orderRepository */
    private $orderRepository;
    /** @var OrderItemRepository $orderItemRepository */
    private $orderItemRepository;
    /** @var StatusRepository $statusRepository */
    private $statusRepository;

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->cartItemRepository = $entityManager->getRepository(CartItem::class);
        $this->recordRepository = $entityManager->getRepository(Record::class);
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->orderRepository = $entityManager->getRepository(Order::class);
        $this->orderItemRepository = $entityManager->getRepository(OrderItem::class);
        $this->statusRepository = $entityManager->getRepository(Status::class);
    }

    private function fetchCurrentUser()
    {   
        return $this->userRepository->getCurrentUser();
    }

    public function createOrder($params) 
    {
        $status = $this->statusRepository->find(1);

        if($status == null)
        {
            throw new \Exception("Id 1 doesn't exist! Who deleted it?!!!");
        }

        if ($status->getDescription() != "RECEIVED")
        {
            throw new \Exception("Somebody changed status description! Who did it!");
        }

        $data = [
            'user' => $this->fetchCurrentUser(),
            'status' => $status,
        ];

        $order = $this->orderRepository->createOrder($data);
    }

}