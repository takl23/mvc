<?php

namespace App\Tests\Command;

use Symfony\Component\Console\Command\Command;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use App\Command\ImportExcelCommand;
use App\Service\ImportService;
use App\Service\FileSystemService;
use Exception;

class ImportExcelCommandTest extends TestCase
{
    /** @var ImportService|MockObject */
    private $importServiceMock;

    /** @var FileSystemService|MockObject */
    private $fileSystemServiceMock;

    protected function setUp(): void
    {
        $this->importServiceMock = $this->createMock(ImportService::class);
        $this->fileSystemServiceMock = $this->createMock(FileSystemService::class); // Skapa ett mock för det andra beroendet
    }

    public function testExecuteImportFails()
    {
        // Mock the ImportService
        $this->importServiceMock
            ->expects($this->once())
            ->method('import')
            ->will($this->throwException(new Exception("Some error occurred")));

        // Mock filsystemservice beroendet om det behövs
        $this->fileSystemServiceMock
            ->method('fileExists')
            ->willReturn(true);

        // Instantiate the command with the mocked services
        $command = new ImportExcelCommand($this->importServiceMock, $this->fileSystemServiceMock);

        // Set up the application and command tester
        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:import-excel'));

        // Execute the command
        $commandTester->execute([
            'filePath' => 'path/to/file.xlsx',
            'sheetName' => 'Sheet1',
            'entityClass' => 'App\\Entity\\SomeEntityClass',
        ]);

        // Assert that the command's output contains the failure message
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Failed to import data: Some error occurred', $output);

        // Assert that the command returns failure
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::FAILURE, $statusCode);
    }

    public function testExecuteWhenFileDoesNotExist()
    {
        // Mock FileSystemService to return false for fileExists
        $this->fileSystemServiceMock
            ->method('fileExists')
            ->willReturn(false);

        $command = new ImportExcelCommand($this->importServiceMock, $this->fileSystemServiceMock);

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:import-excel'));

        $commandTester->execute([
            'filePath' => 'path/to/nonexistent/file.xlsx',
            'sheetName' => 'Sheet1',
            'entityClass' => 'App\\Entity\\SomeEntityClass',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('File not found: path/to/nonexistent/file.xlsx', $output);

        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::FAILURE, $statusCode);
    }

    public function testExecuteWithInvalidArguments(): void
    {
        $command = new ImportExcelCommand($this->importServiceMock, $this->fileSystemServiceMock);

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:import-excel'));

        $commandTester->execute([
            'filePath' => 12345,  // Felaktigt argument (borde vara en sträng)
            'sheetName' => 67890,  // Felaktigt argument (borde vara en sträng)
            'entityClass' => null,  // Felaktigt argument (borde vara en sträng)
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Invalid arguments provided.', $output);

        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::FAILURE, $statusCode);
    }

    public function testExecuteWhenFileNotFound(): void
    {
        // Mocka så att fileExists returnerar false, vilket simulerar att filen inte hittas
        $this->fileSystemServiceMock
            ->method('fileExists')
            ->willReturn(false);

        $command = new ImportExcelCommand($this->importServiceMock, $this->fileSystemServiceMock);

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:import-excel'));

        $commandTester->execute([
            'filePath' => 'path/to/nonexistent/file.xlsx',
            'sheetName' => 'Sheet1',
            'entityClass' => 'App\\Entity\\SomeEntityClass',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('File not found: path/to/nonexistent/file.xlsx', $output);

        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::FAILURE, $statusCode);
    }

    public function testExecuteSuccess(): void
    {
        // Mocka så att fileExists returnerar true, vilket simulerar att filen hittas
        $this->fileSystemServiceMock
            ->method('fileExists')
            ->willReturn(true);

        // Mocka ImportService så att import-metoden fungerar utan problem
        $this->importServiceMock
            ->expects($this->once())
            ->method('import');

        $command = new ImportExcelCommand($this->importServiceMock, $this->fileSystemServiceMock);

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:import-excel'));

        $commandTester->execute([
            'filePath' => 'path/to/valid/file.xlsx',
            'sheetName' => 'Sheet1',
            'entityClass' => 'App\\Entity\\SomeEntityClass',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Data imported successfully!', $output);

        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::SUCCESS, $statusCode);
    }


}
