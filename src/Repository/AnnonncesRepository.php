<?php

namespace App\Repository;

use App\Entity\Annonnces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonnces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonnces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonnces[]    findAll()
 * @method Annonnces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonnces::class);
    }

    // /**
    //  * @return Annonnces[] Returns an array of Annonnces objects
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
    public function findOneBySomeField($value): ?Annonnces
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
