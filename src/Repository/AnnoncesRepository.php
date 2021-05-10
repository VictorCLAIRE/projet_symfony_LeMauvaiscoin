<?php

namespace App\Repository;

use App\Entity\Annonces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonces[]    findAll()
 * @method Annonces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonces::class);
    }

    public function  toutesAnnoncesDecroissant(){
        return $this->createQueryBuilder('annonce')
            ->orderBy('annonce.id','DESC')
            ->getQuery()
            ->getResult();
    }
    public function  toutesAnnoncesPrixDecroissant(int $prix){
        return $this->createQueryBuilder('annonce')
            ->where('annonce.prix_annonce < :prix')
            ->setParameter('prix', $prix)
            ->orderBy('annonce.prix_annonce','ASC')
            ->getQuery()
            ->getResult();
    }

    public function  AnnoncesRecherche($cat,$region, $prixMin, $prixMax,$prix){

        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id','DESC');

        if($cat){
            $query = $query
                ->andWhere('a.categorie_annonce = :categorieid')
                ->setParameter('categorieid', $cat);
        }
        if($region){
            $query = $query
                ->andWhere('a.region_annonce = :regionid')
                ->setParameter('regionid', $region);
        }
        if($prix){
            $query = $query
                ->andWhere('a.prix_annonce BETWEEN :prixMin AND :prixMax')
                ->setParameter('prixMin', $prixMin)
                ->setParameter('prixMax', $prixMax);
        }
        if($prixMin){
            $query = $query
                ->andWhere('a.prix_annonce > :prixMin')
                ->setParameter('prixMin', $prixMin);

        }
        if($prixMax){
            $query = $query
                ->andWhere('a.prix_annonce < :prixMax')
                ->setParameter('prixMax', $prixMax);
        }

        return $query->getQuery()->getResult();
    }


    // /**
    //  * @return Annonces[] Returns an array of Annonces objects
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
    public function findOneBySomeField($value): ?Annonces
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
