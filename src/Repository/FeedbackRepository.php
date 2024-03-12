<?php

namespace App\Repository;

use App\Entity\Feedback;
use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feedback>
 *
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getFilmAverageScore(Film $film): float|int|null
    {
        return $this->createQueryBuilder('f')
            ->select('AVG(f.score)')
            ->where('f.film = :film')
            ->setParameter('film', $film )
            ->getQuery()
            ->getSingleScalarResult();
    }
}

