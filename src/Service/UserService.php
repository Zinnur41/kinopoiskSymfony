<?php

namespace App\Service;

use App\Entity\Feedback;
use App\Entity\Film;
use App\Entity\Subscribe;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    private $entityManager;

    private $hasher;

    private $security;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
        $this->security = $security;
    }

    public function getAllUsers(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function getActiveUser(): UserInterface
    {
        return $this->security->getUser();
    }

    public function addUser(array $data): void
    {
        $user = new User();

        $user->setEmail($data['email']);
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName($data['firstName']);
        $user->setSecondName($data['secondName']);
        $user->setThirdName($data['thirdName']);
        $user->setBirthdayDate($data['birthdayDate']);
        $user->setSubscribe(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function deleteUser(int $id): void
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function addFavoriteFilm(Film $film): void
    {
        $user = $this->getActiveUser();

        $user->addFavoriteFilm($film);
        $this->entityManager->flush();
    }

    public function deleteFavoriteFilm(int $id): void
    {
        $user = $this->getActiveUser();
        $film = $this->entityManager->getRepository(Film::class)->find($id);

        $user->removeFavoriteFilm($film);
        $this->entityManager->flush();
    }

    public function deleteReview(int $id): void
    {
        $feedback = $this->entityManager->getRepository(Feedback::class)->find($id);
        $this->entityManager->remove($feedback);
        $this->entityManager->flush();
    }

    public function addSubscription(int $days): void
    {
        $subscribe = new Subscribe();
        $user = $this->getActiveUser();
        if (!$user->getSubscribe()) {
            $subscribe->addAccount($user);
            date_default_timezone_set('Europe/Moscow');
            $start_date = new DateTime('now');
            $subscribe->setStartDate($start_date);
            $end_date = clone $start_date;
            $subscribe->setEndDate($end_date->modify("+$days day"));
            $this->entityManager->persist($subscribe);
            $this->entityManager->flush();
        }
    }

    public function checkSubscription(): void
    {
        $subscribes = $this->entityManager->getRepository(Subscribe::class)->findAll();
        date_default_timezone_set('Europe/Moscow');
        $currentDate = new DateTime('now');
        $isActiveSubscribe = false;
        foreach ($subscribes as $subscribe) {
            if ($currentDate > $subscribe->getEndDate()) {
                $this->entityManager->remove($subscribe);
                $subscribe->getAccount()->first()->setSubscribe(null);
                $isActiveSubscribe = true;
            }
        }
        if ($isActiveSubscribe) {
            $this->entityManager->flush();
        }
    }

    public function deleteSubscription(): void
    {
        $user = $this->getActiveUser();
        $subscribe = $user->getSubscribe();
        $user->setSubscribe(null);
        $this->entityManager->remove($subscribe);
        $this->entityManager->flush();
    }
}
