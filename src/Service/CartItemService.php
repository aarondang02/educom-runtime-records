<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Record;
use App\Entity\User;

use App\Repository\CartItemRepository;
use App\Repository\RecordRepository;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;

class CartItemService{
    /** @var CartItemRepository $cartItemRepository */    
    private $cartItemRepository;
    /** @var RecordRepository $recordRepository */    
    private $recordRepository;
    /** @var UserRepository $userRepository */    
    private $userRepository;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->cartItemRepository = $entityManager->getRepository(CartItem::class);
        $this->recordRepository = $entityManager->getRepository(Record::class);
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    private function fetchCurrentUser()
    {   
        return $this->userRepository->getCurrentUser();
    }

    public function addToCart($amount, $recordId)
    {   

        $params = [
            'user' => $this->fetchCurrentUser(),
            'record' => $this->recordRepository->find($recordId),
            'amount' => $amount
        ];

        return $this->cartItemRepository->saveCartItem($params);
    }

    public function removeCartItem(CartItem $item)
    {
        
        $user = $this->fetchCurrentUser();

        if ($item->getUser() == $user) #check if user is correct and remove
        {   
            return $this->cartItemRepository->removeCartItem($item);
        }
        else
        {
            return null; #maybe change this later
        }
    }

    public function getCartItems()
    {
        $user = $this->fetchCurrentUser();
        $cartItems = $this->entityManager->getRepository(CartItem::class)->findBy(['user' => $user]);
        return $cartItems;
    }

    public function removeAllCartItems()
    {
        $user = $this->fetchCurrentUser();

        $cartItems = $this->entityManager->getRepository(CartItem::class)->findBy(['user' => $user]);
        foreach ($cartItems as $cartItem)
        {
            $this->cartItemRepository->removeCartItem($cartItem);
        }
        return $cartItems;
    }

    
}
