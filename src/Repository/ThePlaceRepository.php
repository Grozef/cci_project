<?php

namespace App\Repository;

use App\Entity\ThePlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ThePlace>
 *
 * @method ThePlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThePlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThePlace[]    findAll()
 * @method ThePlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThePlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThePlace::class);
    }

//    /**
//     * @return ThePlace[] Returns an array of ThePlace objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ThePlace
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
