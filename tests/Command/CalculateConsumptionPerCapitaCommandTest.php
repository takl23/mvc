<?php

namespace App\Tests\Command;

use Symfony\Component\Console\Command\Command;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use App\Command\CalculateConsumptionPerCapitaCommand;
use App\Service\ConsumptionPerCapitaService;

class CalculateConsumptionPerCapitaCommandTest extends TestCase
{
    /**
     * @var ConsumptionPerCapitaService&MockObject
     */
    private $consumptionPerCapitaServiceMock;

    protected function setUp(): void
    {
        // Mock the ConsumptionPerCapitaService
        $this->consumptionPerCapitaServiceMock = $this->createMock(ConsumptionPerCapitaService::class);
    }

    public function testExecute(): void
    {
        // Expect the calculateAndSaveConsumptionPerCapita method to be called once
        $this->consumptionPerCapitaServiceMock
            ->expects($this->once())
            ->method('calculateAndSaveConsumptionPerCapita');

        // Instantiate the command with the mocked service
        $command = new CalculateConsumptionPerCapitaCommand($this->consumptionPerCapitaServiceMock);

        // Set up the application and command tester
        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:calculate-consumption-per-capita'));

        // Execute the command
        $commandTester->execute([]);

        // Assert that the command's output contains the success message
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Consumption per capita calculated and saved successfully.', $output);

        // Assert that the command returns success
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::SUCCESS, $statusCode);
    }
}
