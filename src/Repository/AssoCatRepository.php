<?php

namespace App\Repository;

use App\Entity\AssoCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssoCat>
 *
 * @method AssoCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssoCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssoCat[]    findAll()
 * @method AssoCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssoCatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssoCat::class);
    }

//    /**
//     * @return AssoCat[] Returns an array of AssoCat objects
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

//    public function findOneBySomeField($value): ?AssoCat
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
