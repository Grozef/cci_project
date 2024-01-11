<?php

namespace App\Repository;

use App\Entity\AssoAward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssoAward>
 *
 * @method AssoAward|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssoAward|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssoAward[]    findAll()
 * @method AssoAward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssoAwardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssoAward::class);
    }

//    /**
//     * @return AssoAward[] Returns an array of AssoAward objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssoAward
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
