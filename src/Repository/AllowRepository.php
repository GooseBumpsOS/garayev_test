<?php

namespace App\Repository;

use App\Entity\Allow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Allow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Allow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Allow[]    findAll()
 * @method Allow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllowRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Allow::class);
    }

    // /**
    //  * @return Allow[] Returns an array of Allow objects
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
    public function findOneBySomeField($value): ?Allow
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
