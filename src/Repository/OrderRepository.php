<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Order::class);
        $this->entityManager = $entityManager;
    }

    private function generateOrderNumber()
    {
        $lastOrder = $this->entityManager->getRepository(Order::class)->findOneBy([], ['id' => 'DESC']);
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

    public function saveOrder($params)
    {
        $order = new Order();
        $order->setUser($params['user']);
        $order->setStatus($params['status']);
        $order->setOrderNumber($this->generateOrderNumber());
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }

    //    /**
    //     * @return Order[] Returns an array of Order objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Order
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
