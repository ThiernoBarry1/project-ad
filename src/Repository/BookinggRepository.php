<?php

namespace App\Repository;

use App\Entity\Bookingg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bookingg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookingg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookingg[]    findAll()
 * @method Bookingg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookinggRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bookingg::class);
    }

    // /**
    //  * @return Bookingg[] Returns an array of Bookingg objects
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
    public function findOneBySomeField($value): ?Bookingg
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
