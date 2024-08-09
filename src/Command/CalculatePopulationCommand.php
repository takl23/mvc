<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\PopulationElomradeService;

#[AsCommand(
    name: 'app:calculate-population-elomrade',
    description: 'Calculates and saves population per elomrade'
)]
class CalculatePopulationCommand extends Command
{
    private $populationElomradeService;
    private $entityManager;

    public function __construct(PopulationElomradeService $populationElomradeService, EntityManagerInterface $entityManager)
    {
        $this->populationElomradeService = $populationElomradeService;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        // You can define additional configuration here if needed.
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->populationElomradeService->calculateAndSavePopulationPerElomrade($this->entityManager);
        $io->success('Population per elomrade calculated and saved successfully.');
        return Command::SUCCESS;
    }
}
