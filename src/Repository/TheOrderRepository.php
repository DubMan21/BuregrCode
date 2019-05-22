<?php

namespace App\Repository;

use App\Entity\TheOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TheOrder::class);
    }

    public function deleteUselessOrder()
    {
        $this->createQueryBuilder('o')
            ->delete()
            ->where('o.order_at IS NULL')
            ->andWhere("CURRENT_DATE() > DATE_ADD(o.created_at, 1, 'day')")
            ->getQuery()
            ->execute();

    }

    public function findAllValid()
    {
        return $this->createQueryBuilder('o')
            ->where('o.order_at IS NOT NULL')
            ->orderBy('o.order_at', 'DESC')
            ->getQuery()
            ->execute();
    }



    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
