<?php

namespace App\Repository;

use App\Entity\Paintings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Paintings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paintings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paintings[]    findAll()
 * @method Paintings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaintingsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Paintings::class);
    }

    // /**
    //  * @return Paintings[] Returns an array of Paintings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Paintings
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
