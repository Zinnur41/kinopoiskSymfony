<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:list-users',
    description: 'List all users from the database',
)]
class UsersListCommand extends Command
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command show all users form the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $io = new SymfonyStyle($input, $output);

        $io->success([$this->getDescription()]);

        foreach ($users as $user) {
            $output->writeln('<info>Email: </info>' . $user->getEmail());
            $output->writeln('<info>FirstName: </info>' . $user->getFirstName());
            $output->writeln('<info>SecondName: </info>' . $user->getSecondName());
            $output->writeln('<info>BirthdayDate: </info>' . $user->getBirthdayDate()->format('Y-m-d'));

            $output->writeln('============================');
        }
        return Command::SUCCESS;
    }
}
