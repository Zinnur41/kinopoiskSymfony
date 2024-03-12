<?php

namespace App\Repository;

use App\Entity\SiteFeedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getAverageScore(): float|int|null
    {
        return $this->createQueryBuilder('sf')
            ->select('AVG(sf.score)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
