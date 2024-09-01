<?php

namespace App\Tests\Command;

use Symfony\Component\Console\Command\Command;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use App\Command\CalculatePopulationCommand;
use App\Service\PopulationElomradeService;

class CalculatePopulationCommandTest extends TestCase
{
    /**
     * @var PopulationElomradeService|MockObject
     */
    private $populationElomradeServiceMock;

    protected function setUp(): void
    {
        // Mock the PopulationElomradeService
        $this->populationElomradeServiceMock = $this->createMock(PopulationElomradeService::class);
    }

    public function testExecute()
    {
        // Expect the calculateAndSavePopulationPerElomrade method to be called once
        $this->populationElomradeServiceMock
            ->expects($this->once())
            ->method('calculateAndSavePopulationPerElomrade');

        // Instantiate the command with the mocked service
        $command = new CalculatePopulationCommand($this->populationElomradeServiceMock);

        // Set up the application and command tester
        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($application->find('app:calculate-population-elomrade'));

        // Execute the command
        $commandTester->execute([]);

        // Assert that the command's output contains the success message
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Population per elomrade calculated and saved successfully.', $output);

        // Assert that the command returns success
        $statusCode = $commandTester->getStatusCode();
        $this->assertEquals(Command::SUCCESS, $statusCode);
    }
}
