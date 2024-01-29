<?php

namespace App\Service;

use App\Entity\Feedback;
use App\Entity\SiteFeedback;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class SiteFeedbackService
{
    private $entityManager;

    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function getAllSiteFeedback()
    {
        return $this->entityManager->getRepository(SiteFeedback::class)->findAll();
    }

    public function addSiteFeedback(array $data): void
    {
        $feedback = new SiteFeedback();

        $user = $this->security->getUser();

        $feedback->setReviewer($user);
        $feedback->setComment($data['comment']);
        $feedback->setScore($data['score']);
        date_default_timezone_set('Europe/Moscow');
        $date = new DateTime('now');
        $feedback->setDate($date);

        $this->entityManager->persist($feedback);
        $this->entityManager->flush();
    }

    public function getAverageScore()
    {
        $averageScore = $this->entityManager->getRepository(SiteFeedback::class)->getAverageScore();
        return round($averageScore, 2);
    }
}