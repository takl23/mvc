<?php

namespace App\ExcelImport;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:import-excel',
    description: 'Imports data from an Excel file to RenewableEnergyTWh'
)]
class ImportExcelCommand extends Command
{
    protected static $defaultName = 'app:import-excel';
    private $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports data from an Excel file to RenewableEnergyTWh')
            ->addArgument('filePath', InputArgument::REQUIRED, 'Path to the Excel file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath');
        $this->importService->import($filePath);
        $output->writeln('Data imported successfully!');

        return Command::SUCCESS;
    }
}
