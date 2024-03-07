<?php

namespace App\Service;

use App\Entity\Film;
use App\Entity\User;
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
}
