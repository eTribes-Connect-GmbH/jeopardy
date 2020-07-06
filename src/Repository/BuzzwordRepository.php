<?php

namespace App\Repository;

use App\Entity\Buzzword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Buzzword|null find($id, $lockMode = null, $lockVersion = null)
 * @method Buzzword|null findOneBy(array $criteria, array $orderBy = null)
 * @method Buzzword[]    findAll()
 * @method Buzzword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuzzwordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Buzzword::class);
    }

    // /**
    //  * @return Buzzword[] Returns an array of Buzzword objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Buzzword
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
