<?php

namespace App\Repository;

use App\Entity\Inscr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inscr>
 *
 * @method Inscr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscr[]    findAll()
 * @method Inscr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscr::class);
    }

//    /**
//     * @return Inscr[] Returns an array of Inscr objects
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

//    public function findOneBySomeField($value): ?Inscr
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
