<?php

namespace App\Service;

use App\Entity\Category;
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

    public function deleteFilmOrSerial(int $id): void
    {
        $film = $this->entityManager->getRepository(Film::class)->find($id);
        $this->entityManager->remove($film);
        $this->entityManager->flush();
    }

    public function addFilm(array $data, $image): void
    {
        $film = new Film();
        $category = $this->entityManager->getRepository(Category::class)->find(1); // Категория фильмов

        $film->setName($data['name']);
        $film->setDescription($data['description']);
        $film->setRating($data['rating']);
        $film->setCategory($category);
        $film->setImage($image);

        $this->entityManager->persist($film);
        $this->entityManager->flush();
    }

    public function addSerial(array $data, $image): void
    {
        $film = new Film();
        $category = $this->entityManager->getRepository(Category::class)->find(2); // Категория сериалов

        $film->setName($data['name']);
        $film->setDescription($data['description']);
        $film->setRating($data['rating']);
        $film->setCategory($category);
        $film->setImage($image);

        $this->entityManager->persist($film);
        $this->entityManager->flush();
    }
}