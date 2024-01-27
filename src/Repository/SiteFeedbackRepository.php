<?php

namespace App\Repository;

use App\Entity\SiteFeedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiteFeedback>
 *
 * @method SiteFeedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteFeedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteFeedback[]    findAll()
 * @method SiteFeedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteFeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteFeedback::class);
    }

//    /**
//     * @return SiteFeedback[] Returns an array of SiteFeedback objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SiteFeedback
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
