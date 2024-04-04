<?php

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'check-subscriptions',
    description: 'This command check users subscriptions',
)]
class CheckSubscriptionCommand extends Command
{
    private $userService;
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command check users subscriptions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->userService->checkSubscription();
        $io->success('Подписки проверены!');
        return Command::SUCCESS;
    }
}
