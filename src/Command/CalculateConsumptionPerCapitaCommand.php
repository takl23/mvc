<?php

// src/Service/CalculateConsumptionPerCapitaCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Service\ConsumptionPerCapitaService;

#[AsCommand(
    name: 'app:calculate-consumption-per-capita',
    description: 'Calculates and saves consumption per capita for each elomrade'
)]
class CalculateConsumptionPerCapitaCommand extends Command
{
    private ConsumptionPerCapitaService $consumptionPerCapitaService;

    public function __construct(ConsumptionPerCapitaService $consumptionPerCapitaService)
    {
        $this->consumptionPerCapitaService = $consumptionPerCapitaService;
        parent::__construct();
    }

    protected function configure(): void
    {
        // Additional configuration if needed
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->consumptionPerCapitaService->calculateAndSaveConsumptionPerCapita();

        $io->success('Consumption per capita calculated and saved successfully.');

        return Command::SUCCESS;
    }
}
