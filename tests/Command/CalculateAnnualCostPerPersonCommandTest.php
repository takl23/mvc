<?php

namespace App\Tests\Command;

use Symfony\Component\Console\Command\Command;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Psr\Log\LoggerInterface;
use App\Command\CalculateAnnualCostPerPersonCommand;
use App\Service\AverageAnnualCostPerPersonService;

class CalculateAnnualCostPerPersonCommandTest extends TestCase
{
    /**
     * @var AverageAnnualCostPerPersonService&MockObject
     */
    private $serviceMock;

    /**
     * @var LoggerInterface&MockObject
     */
    private $loggerMock;

    protected function setUp(): void
    {
        // Mock the AverageAnnualCostPerPersonService
        $this->serviceMock = $this->createMock(AverageAnnualCostPerPersonService::class);

        // Mock the LoggerInterface
        $this->loggerMock = $this->createMock(LoggerInterface::class);
    }

    public function testExecute(): void
    {
        // Expect the calculateAndSaveAverageAnnualCostPerPerson method to be called once
        $this->serviceMock
            ->expects($this->once())
            ->method('calculateAndSaveAverageAnnualCostPerPerson');

        // Expect the logger to log messages
        $this->loggerMock
            ->expects($this->exactly(2))
            ->method('info')
            ->withConsecutive(
                ['Executing command: app:calculate-annual-cost-per-person'],
                ['Finished executing command: app:calculate-annual-cost-per-person']
            );

        // Instantiate the command with the mocked service and logger
        $command = new CalculateAnnualCostPerPersonCommand($this->serviceMock, $this->loggerMock);

        // Set up the application and command tester
        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:calculate-annual-cost-per-person'));

        // Execute the command
        $commandTester->execute([]);

        // Assert that the command's output contains the success message
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Annual cost per person calculated and saved successfully.', $output);

        // Assert that the command returns success
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::SUCCESS, $statusCode);
    }
}
