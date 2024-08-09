<?php

namespace App\Command;

use App\Service\AverageAnnualCostPerPersonService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:calculate-annual-cost-per-person',
    description: 'Calculate the annual electricity cost per person per elområde'
)]
class CalculateAnnualCostPerPersonCommand extends Command
{
    private $service;

    public function __construct(AverageAnnualCostPerPersonService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Calculates the annual electricity cost per person per elområde.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->service->calculateAndSaveAverageAnnualCostPerPerson();
        $io->success('Annual cost per person calculated and saved successfully.');

        return Command::SUCCESS;
    }
}
