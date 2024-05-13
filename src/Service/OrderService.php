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

    private function generateOrderNumber()
    {
        $lastOrder = $this->orderRepository->getLastOrder();
        if ($lastOrder) 
        {
            $lastOrderNumber = $lastOrder->getOrderNumber();
            $lastOrderNumber = substr($lastOrderNumber, 3);
            $lastOrderNumber = (int) $lastOrderNumber;
            $lastOrderNumber++;
        } 
        else 
        {
            $lastOrderNumber = 1;
        }
        $orderNumber = 'ORD'. str_pad($lastOrderNumber, 13, '0', STR_PAD_LEFT);
        return $orderNumber;
    }

    public function createNewOrder() 
    {
        $status = $this->statusRepository->findStatus(1); #automatically get "RECEIVED" status

        #safety checks
        if($status == null)
        {
            throw new \Exception("Id 1 doesn't exist! Who deleted it?!!!");
        }
        if ($status->getDescription() != "RECEIVED")
        {
            throw new \Exception("Somebody changed status description! Who did it?!!!!!!");
        }

        $data = [
            'user' => $this->fetchCurrentUser(),
            'status' => $status,
            'orderNumber' => $this->generateOrderNumber(),
        ];

        $order = $this->orderRepository->saveOrder($data);
        return $order;
    }

    public function getOrders()
    {
        return $this->orderRepository->findUserOrders($this->fetchCurrentUser());
    }

    public function changeStatus($params)
    {   
        $data = [
            "order" => $this->orderRepository->findOrder($params['order_id']),
            "status" => $this->statusRepository->findStatus($params['status_id']),
        ];
         
        return $this->orderRepository->changeOrderStatus($data);
    }

    public function findByOrderNumber($orderNumber)
    {
        return $this->orderRepository->findByOrderNumber($orderNumber);
    }

}