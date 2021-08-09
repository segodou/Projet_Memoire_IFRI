<?php

namespace App\Repository;

use App\Entity\SuperMarket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SuperMarket|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuperMarket|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuperMarket[]    findAll()
 * @method SuperMarket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperMarketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuperMarket::class);
    }

    // /**
    //  * @return SuperMarket[] Returns an array of SuperMarket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SuperMarket
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
