<?php

namespace App\Repository;

use App\Entity\InGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InGroup>
 *
 * @method InGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method InGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method InGroup[]    findAll()
 * @method InGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InGroup::class);
    }

//    /**
//     * @return InGroup[] Returns an array of InGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InGroup
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
