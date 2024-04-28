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

    public function __construct(EntityManagerInterface $entityManager) {
        $this->cartItemRepository = $entityManager->getRepository(CartItem::class);
        $this->recordRepository = $entityManager->getRepository(Record::class);
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    private function fetchCurrentUser()
    {   
        $user = $this->userRepository->getCurrentUser();

        if ($user == null)
        {
            return null;
        }

        else
        {
            return $user;
        }
        
    }

    public function toCart($amount, $recordId)
    {   

        $params = [
            'user' => $this->fetchCurrentUser(),
            'record' => $this->recordRepository->find($recordId),
            'amount' => $amount
        ];

        return $this->cartItemRepository->saveCartItem($params);
    }

    public function removeCartItem($cartItemId, EntityManagerInterface $entityManager)
    {
        
        $user = $this->userRepository->getCurrentUser();
        if ($user == null){
            return null; #maybe change this later
        }

        $cartItem = $this->cartItemRepository->find($cartItemId);

        if ($cartItem->getUser() == $user){ #check if user is correct and remove
            return $this->cartItemRepository->removeCartItem($cartItem);
        }
        else
        {
            return null; #maybe change this later
        }
    }

    public function getCartItems(EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->getCurrentUser();
        if ($user == null){
            return null;
        }
        $cartItems = $entityManager->getRepository(CartItem::class)->findBy(['user' => $user]);
        return $cartItems;
    }

    public function removeAllCartItem(EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->getCurrentUser();
        if ($user == null){
            return null; #maybe change this later
        }
        $cartItems = $entityManager->getRepository(CartItem::class)->findBy(['user' => $user]);
        foreach ($cartItems as $cartItem)
        {
            $entityManager->remove($cartItem);
        }
        $entityManager->flush();
        return $cartItems;
    }

    
}
