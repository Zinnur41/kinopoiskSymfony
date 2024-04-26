<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Feedback;
use App\Entity\Film;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class FilmService
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function getAllFilms(): array
    {
        return $this->entityManager->getRepository(Film::class)->findBy(['category' => 1]); // Категория фильмов
    }

    public function getAllSerials(): array
    {
        return $this->entityManager->getRepository(Film::class)->findBy(['category' => 2]); // Категория сериалов
    }

    public function deleteFilmOrSerial(int $id): void
    {
        $film = $this->entityManager->getRepository(Film::class)->find($id);
        $this->entityManager->remove($film);
        $this->entityManager->flush();
    }


    public function getFilm(int $id)
    {
        return $this->entityManager->getRepository(Film::class)->find($id);
    }

    /**
     * @param Film $film
     * @param array $data
     * @param Category $category
     * @param $image
     * @return void
     */
    public function extracted(Film $film, array $data, Category $category, $image): void
    {
        $film->setName($data['name']);
        $film->setDescription($data['description']);
        $film->setRating($data['rating']);
        $film->setCategory($category);
        $film->setImage($image);
        $film->setBudget($data['budget']);
        $film->setCountry($data['country']);
        $film->setReleaseDate($data['releaseDate']);

        $this->entityManager->persist($film);
        $this->entityManager->flush();
    }

    public function addFilm(array $data, $image, ArrayCollection $genres): void
    {
        $film = new Film();
        foreach ($genres as $genre) {
            $film->addGenre($genre);
        }

        $category = $this->entityManager->getRepository(Category::class)->find(1); // Категория фильмов

        $this->extracted($film, $data, $category, $image);
    }

    public function addSerial(array $data, $image, ArrayCollection $genres): void
    {
        $serial = new Film();
        foreach ($genres as $genre) {
            $serial->addGenre($genre);
        }

        $category = $this->entityManager->getRepository(Category::class)->find(2); // Категория сериалов

        $this->extracted($serial, $data, $category, $image);
    }

    public function updateFilm(Film $film, $image): void
    {
        $film->setImage($image);
        $this->entityManager->flush();
    }


    public function addFeedback(int $id, array $data): void
    {
        $film = $this->getFilm($id);
        $user = $this->security->getUser();

        $feedback = new Feedback();

        $feedback->setFilm($film);
        $feedback->setScore($data['rating']);
        $feedback->setComment($data['comment']);
        $feedback->setReviewer($user);
        date_default_timezone_set('Europe/Moscow');
        $date = new DateTime('now');
        $feedback->setDate($date);

        $this->entityManager->persist($feedback);
        $this->entityManager->flush();
    }

    public function getFilmAverageScore(Film $film): int|float|null
    {
        return $this->entityManager->getRepository(Feedback::class)->getFilmAverageScore($film);
    }
}