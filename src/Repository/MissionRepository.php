<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function findFiveLatestMissionsPending(): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.status_mission = :status')
            ->setParameter('status', 1) // 1 = "en attente"
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findOpenMissions(): array
    {
        return $this->createQueryBuilder('m')
            ->join('m.status_mission', 's')
            ->andWhere('s.label = :label')
            ->setParameter('label', 'en attente')
            ->orderBy('m.created_at', 'DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    public function countMissionsByLabel(string $label): int
    {
        return (int) $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->join('m.status_mission', 's')
            ->andWhere('s.label = :label')
            ->setParameter('label', $label)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return Mission[] Returns an array of Mission objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Mission
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
