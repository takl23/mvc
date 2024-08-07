<?php

namespace App\ExcelImport;

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

#[AsCommand(
    name: 'app:reset-and-import-data',
    description: 'Resets the database and imports data from Excel files'
)]
class ResetAndImportDataCommand extends Command
{
    private $entityManager;
    private $importService;

    public function __construct(EntityManagerInterface $entityManager, ImportService $importService)
    {
        $this->entityManager = $entityManager;
        $this->importService = $importService;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Resets the database and imports data from Excel files');
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

        $io->success('Tables cleared.');

        // Import new data
        $io->section('Importing new data...');

        // Lägg till dina importkommandon här
        // Till exempel:
        $this->importService->import('src/ExcelImport/importfile.xlsx', '7.2.1.2', RenewableEnergyTWh::class);
        $this->importService->import('src/ExcelImport/importfile.xlsx', '7.2.1.1', RenewableEnergyPercentage::class);
        $this->importService->import('src/ExcelImport/importfile.xlsx', 'Snittförbrukning per elområde', ElectricityPrice::class);
        $this->importService->import('src/ExcelImport/importfile.xlsx', 'Snittförbrukning per elområde', AverageConsumption::class);
        $this->importService->import('src/ExcelImport/importfile.xlsx', '7.3.1', EnergySupplyGDP::class);

        $io->success('Data import complete.');

        return Command::SUCCESS;
    }

    private function clearTable(string $entityClass)
    {
        $cmd = $this->entityManager->getClassMetadata($entityClass);
        $connection = $this->entityManager->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();

        $connection->executeQuery('DELETE FROM ' . $cmd->getTableName());
        $connection->executeQuery('VACUUM'); // To reclaim the space
    }
}
