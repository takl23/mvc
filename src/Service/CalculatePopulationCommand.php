<?php

namespace App\Service;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:calculate-population-elomrade',
    description: 'Calculates and saves population per elomrade'
)]
class CalculatePopulationCommand extends Command
{
    private PopulationElomradeService $populationElomradeService;

    public function __construct(PopulationElomradeService $populationElomradeService)
    {
        $this->populationElomradeService = $populationElomradeService;
        parent::__construct();
    }

    protected function configure(): void
    {
        // You can define additional configuration here if needed.
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->populationElomradeService->calculateAndSavePopulationPerElomrade();
        $io->success('Population per elomrade calculated and saved successfully.');
        return Command::SUCCESS;
    }
}
