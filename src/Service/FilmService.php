<?php

namespace App\Service;

use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;

class FilmService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllFilms(): array
    {
        return $this->entityManager->getRepository(Film::class)->findBy(['category' => 1]);
    }

    public function getAllSerials(): array
    {
        return $this->entityManager->getRepository(Film::class)->findBy(['category' => 2]);
    }
}