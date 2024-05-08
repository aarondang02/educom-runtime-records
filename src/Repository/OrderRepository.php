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

    public function saveOrder($params)
    {
        if(isset($params["id"]) && $params["id"] != "")
        {
            $order = $this->find($params["id"]);
        }
        else 
        {
            $order = new Order();
        }

        $order->setUser($params['user']);
        $order->setStatus($params['status']);
        $order->setOrderNumber($params['orderNumber']);
        $order->setOrderDate(new \DateTimeImmutable());
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }

    public function changeOrderStatus($params)
    {
        $order = $params['order'];
        $order->setStatus($params['status']);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }

    public function findOrder($id)
    {
        return $this->find($id);
    }

    public function findLastOrder()
    {
        return $this->findOneBy([], ['id' => 'DESC']);
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
