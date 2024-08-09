<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ImportService;

#[AsCommand(
    name: 'app:import-excel',
    description: 'Import data from an Excel file'
)]
class ImportExcelCommand extends Command
{
    private $importService;
    private $entityManager;

    public function __construct(ImportService $importService, EntityManagerInterface $entityManager)
    {
        $this->importService = $importService;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports data from an Excel file')
            ->addArgument('filePath', InputArgument::REQUIRED, 'Path to the Excel file')
            ->addArgument('sheetName', InputArgument::REQUIRED, 'The name of the sheet to import')
            ->addArgument('entityClass', InputArgument::REQUIRED, 'The entity class to import the data into');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath');
        $sheetName = $input->getArgument('sheetName');
        $entityClass = $input->getArgument('entityClass');
        $io = new SymfonyStyle($input, $output);

        if (!file_exists($filePath)) {
            $io->error('File not found: ' . $filePath);
            return Command::FAILURE;
        }

        try {
            $this->importService->import($filePath, $sheetName, $entityClass, $this->entityManager);
            $io->success('Data imported successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Failed to import data: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
