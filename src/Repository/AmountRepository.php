<?php

namespace App\Repository;

use App\Entity\Amount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Amount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amount[]    findAll()
 * @method Amount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Amount::class);
    }

    // /**
    //  * @return Amount[] Returns an array of Amount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Amount
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
