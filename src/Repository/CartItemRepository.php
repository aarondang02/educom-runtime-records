<?php

namespace App\Repository;

use App\Entity\CartItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<CartItem>
 *
 * @method CartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartItem[]    findAll()
 * @method CartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartItemRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, CartItem::class);
        $this->entityManager = $entityManager;
    }
    
    public function saveCartItem($params)
    {
        if(isset($params["id"]) && $params["id"] != "")
        {
            $cartItem = $this->find($params["id"]);
        }
        else 
        {
            $cartItem = new CartItem();
        }

        $cartItem->setAmount($params["amount"]);
        $cartItem->setRecord($params["record"]);
        $cartItem->setUser($params["user"]);
        
        $entityManager = $this->getEntityManager();
        $entityManager->persist($cartItem);
        $entityManager->flush();
        
        return $cartItem;
    }

    public function removeCartItem(CartItem $cartItem)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($cartItem);
        $entityManager->flush();
    }

//    /**
//     * @return CartItem[] Returns an array of CartItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CartItem
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
