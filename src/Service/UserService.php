<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private $entityManager;

    private $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    public function getAllUsers(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
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
}