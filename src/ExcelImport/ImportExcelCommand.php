<?php
namespace App\ExcelImport;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Entity\AverageConsumption;

#[AsCommand(
    name: 'app:import-excel',
    description: 'Imports data from an Excel file to AverageConsumption'
)]
class ImportExcelCommand extends Command
{
    private $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports data from an Excel file to AverageConsumption')
            ->addArgument('filePath', InputArgument::REQUIRED, 'Path to the Excel file')
            ->addArgument('sheetName', InputArgument::REQUIRED, 'Name of the Excel sheet');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath');
        $sheetName = $input->getArgument('sheetName');
        $io = new SymfonyStyle($input, $output);

        if (!file_exists($filePath)) {
            $io->error('File not found: ' . $filePath);
            return Command::FAILURE;
        }

        try {
            $this->importService->import($filePath, $sheetName, AverageConsumption::class);
            $io->success('Data imported successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Failed to import data: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
