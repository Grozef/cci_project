<?php

namespace App\Repository;

use App\Entity\TheReunion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TheReunion>
 *
 * @method TheReunion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TheReunion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TheReunion[]    findAll()
 * @method TheReunion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheReunionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TheReunion::class);
    }

//    /**
//     * @return TheReunion[] Returns an array of TheReunion objects
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

//    public function findOneBySomeField($value): ?TheReunion
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
