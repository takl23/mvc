<?php

// src/Command/CalculateAnnualCostPerPersonCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Service\AverageAnnualCostPerPersonService;
use Psr\Log\LoggerInterface;

#[AsCommand(
    name: 'app:calculate-annual-cost-per-person',
    description: 'Calculate the annual electricity cost per person per elområde'
)]
class CalculateAnnualCostPerPersonCommand extends Command
{
    private AverageAnnualCostPerPersonService $service;
    private LoggerInterface $logger;

    public function __construct(AverageAnnualCostPerPersonService $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Calculates the annual electricity cost per person per elområde.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->logger->info('Executing command: app:calculate-annual-cost-per-person');

        $this->service->calculateAndSaveAverageAnnualCostPerPerson();

        $io->success('Annual cost per person calculated and saved successfully.');
        $this->logger->info('Finished executing command: app:calculate-annual-cost-per-person');

        return Command::SUCCESS;
    }
}
