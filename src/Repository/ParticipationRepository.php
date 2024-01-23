<?php

namespace App\Repository;

use App\Entity\Participation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Participant;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @extends ServiceEntityRepository<Participation>
 *
 * @method Participation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participation[]    findAll()
 * @method Participation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    public function colParticipant(): array
    {
        $qb = $this->createQueryBuilder('u')
            ->from('App\Entity\Participant', 'p')
            ->where('p.inscription_id = 1')
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function lesParticipants($inscriptionID): array
    { 
        $inscriptionID = 1;
        $queryBuilder = $this->createQueryBuilder('q')
            ->select('p.nom', 'p.prenom', 'p.tel', 'p.mail')
            ->from('App\Entity\Participant', 'p')
            ->where('p.inscription_id = :inscriptionId');
            //->where('p.inscription_id = :inscriptionId')
            //->setParameter('inscriptionId', $inscriptionId);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
        //return $queryBuilder->getQuery()->getResult();
    }

//    /**
//     * @return Participation[] Returns an array of Participation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Participation
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
