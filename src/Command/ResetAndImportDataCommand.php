<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\RenewableEnergyTWh;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\ElectricityPrice;
use App\Entity\AverageConsumption;
use App\Entity\EnergySupplyGDP;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerLan;
use App\Service\ImportService;

#[AsCommand(
    name: 'app:reset-and-import-data',
    description: 'Resets the database and imports data from CSV files'
)]
class ResetAndImportDataCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private ImportService $importService;

    public function __construct(EntityManagerInterface $entityManager, ImportService $importService)
    {
        $this->entityManager = $entityManager;
        $this->importService = $importService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Resets the database and imports data from CSV files');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->section('Resetting data in tables...');

        // Clear the tables
        $this->clearTable(RenewableEnergyTWh::class);
        $this->clearTable(RenewableEnergyPercentage::class);
        $this->clearTable(ElectricityPrice::class);
        $this->clearTable(AverageConsumption::class);
        $this->clearTable(EnergySupplyGDP::class);
        $this->clearTable(LanElomrade::class);
        $this->clearTable(PopulationPerLan::class);

        $io->success('Tables cleared.');

        // Import new data from CSV files
        $io->section('Importing new data...');

        $this->importService->import('src/csv/renewable_energy_twh.csv', RenewableEnergyTWh::class);
        $this->importService->import('src/csv/renewable_energy_percentage.csv', RenewableEnergyPercentage::class);
        $this->importService->import('src/csv/electricity_price.csv', ElectricityPrice::class);
        $this->importService->import('src/csv/average_consumption.csv', AverageConsumption::class);
        $this->importService->import('src/csv/energy_supply_gdp.csv', EnergySupplyGDP::class);
        $this->importService->import('src/csv/lan_elomrade.csv', LanElomrade::class);
        $this->importService->import('src/csv/population_per_lan.csv', PopulationPerLan::class);

        $io->success('Data import complete.');

        return Command::SUCCESS;
    }

    private function clearTable(string $entityClass): void
    {
        $cmd = $this->entityManager->getClassMetadata($entityClass);
        $connection = $this->entityManager->getConnection();

        $connection->executeQuery('DELETE FROM ' . $cmd->getTableName());
        $connection->executeQuery('VACUUM');
    }
}
