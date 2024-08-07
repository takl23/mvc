<?php

namespace App\ExcelImport;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:calculate-average-cost',
    description: 'Calculate average cost per elområde and year'
)]
class CalculateAverageCostCommand extends Command
{
    private $averageCostService;

    public function __construct(AverageCostService $averageCostService)
    {
        $this->averageCostService = $averageCostService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Calculate average cost per elområde and year');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->averageCostService->calculateAverageCost();
            $io->success('Average costs calculated and saved successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Failed to calculate average costs: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
