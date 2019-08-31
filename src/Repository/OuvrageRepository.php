<?php

namespace App\Repository;

use App\Entity\Ouvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ouvrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ouvrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ouvrage[]    findAll()
 * @method Ouvrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvrageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ouvrage::class);
    }

   public function findAllQuerry()
   {
       return $this->createQueryBuilder('o')
           ->orderBy('o.Theme_id')
           ->getQuery()
       ;
   }
   public function search($value)
   {
       return$this->createQueryBuilder('o')
           ->select('o')
           ->where('o.Titre' == $value or 'o.Theme_id.libelle' == strtoupper($value) or 'o.Auteur_id.libelle' == $value)
           ->getQuery();
   }
   // /**
   //  * @return Ouvrage[] Returns an array of Ouvrage objects
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
    public function findOneBySomeField($value): ?Ouvrage
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
