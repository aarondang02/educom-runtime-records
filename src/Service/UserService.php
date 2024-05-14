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

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function saveUser($params)
    {
        $data = [
            "id" => $params["id"],
            "firstname" => $params["firstname"],
            "lastname" => $params["lastname"],
            "email" => $params["email"],
        ];
        $this->userRepository->saveUser($data);
    }
}