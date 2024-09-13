<?php

namespace App\Tests\Command;

use App\Command\ResetAndImportDataCommand;
use App\Service\ImportService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;

class ResetAndImportDataCommandTest extends TestCase
{
    /** @var EntityManagerInterface&MockObject */
    private $entityManagerMock;

    /** @var ImportService&MockObject */
    private $importServiceMock;

    protected function setUp(): void
    {
        // Initialize the mock properties
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->importServiceMock = $this->createMock(ImportService::class);
    }

    public function testExecute(): void
    {
        // Mock ClassMetadata
        $classMetadataMock = $this->createMock(ClassMetadata::class);
        $classMetadataMock
            ->expects($this->any())
            ->method('getTableName')
            ->willReturn('some_table_name');

        $this->entityManagerMock
            ->expects($this->any())
            ->method('getClassMetadata')
            ->willReturn($classMetadataMock);

        // Mock connection
        $connectionMock = $this->getMockBuilder(\Doctrine\DBAL\Connection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityManagerMock
            ->expects($this->any())
            ->method('getConnection')
            ->willReturn($connectionMock);

        // Expect DELETE and VACUUM queries for clearing tables
        $connectionMock
            ->expects($this->exactly(14)) // 7 tables x 2 queries (DELETE + VACUUM)
            ->method('executeQuery')
            ->withConsecutive(
                ['DELETE FROM some_table_name'],
                ['VACUUM']
            );

        // Expect importService->import to be called with specific parameters
        $this->importServiceMock
            ->expects($this->exactly(7))
            ->method('import')
            ->withConsecutive(
                ['src/csv/renewable_energy_twh.csv', \App\Entity\RenewableEnergyTWh::class],
                ['src/csv/renewable_energy_percentage.csv', \App\Entity\RenewableEnergyPercentage::class],
                ['src/csv/electricity_price.csv', \App\Entity\ElectricityPrice::class],
                ['src/csv/average_consumption.csv', \App\Entity\AverageConsumption::class],
                ['src/csv/energy_supply_gdp.csv', \App\Entity\EnergySupplyGDP::class],
                ['src/csv/lan_elomrade.csv', \App\Entity\LanElomrade::class],
                ['src/csv/population_per_lan.csv', \App\Entity\PopulationPerLan::class]
            );

        // Instantiate the command
        $command = new ResetAndImportDataCommand($this->entityManagerMock, $this->importServiceMock);

        // Set up the application and command tester
        $application = new Application();
        $application->add($command);
        $commandTester = new CommandTester($application->find('app:reset-and-import-data'));

        // Execute the command
        $commandTester->execute([]);

        // Assert the output
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Resetting data in tables...', $output);
        $this->assertStringContainsString('Tables cleared.', $output);
        $this->assertStringContainsString('Importing new data...', $output);
        $this->assertStringContainsString('Data import complete.', $output);

        // Assert that the command was successful
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::SUCCESS, $statusCode);
    }
}
