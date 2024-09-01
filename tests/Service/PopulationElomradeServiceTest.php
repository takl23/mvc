<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PopulationPerLan;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerElomrade;
use App\Service\PopulationElomradeService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\MockObject\MockObject;
use InvalidArgumentException;

class PopulationElomradeServiceTest extends TestCase
{
    /** @var EntityManagerInterface|MockObject */
    private $entityManagerMock;

    /** @var MockObject|EntityRepository */
    private $populationPerLanRepositoryMock;

    /** @var MockObject|EntityRepository */
    private $lanElomradeRepositoryMock;

    /** @var PopulationElomradeService */
    private $populationElomradeService;

    protected function setUp(): void
    {
        /** @var EntityManagerInterface|MockObject $entityManagerMock */
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        /** @var EntityRepository|MockObject $populationPerLanRepositoryMock */
        $this->populationPerLanRepositoryMock = $this->createMock(EntityRepository::class);

        /** @var EntityRepository|MockObject $lanElomradeRepositoryMock */
        $this->lanElomradeRepositoryMock = $this->createMock(EntityRepository::class);

        // Mock the connection and platform
        $connectionMock = $this->createMock(Connection::class);
        $platformMock = $this->createMock(AbstractPlatform::class);

        // Set expectations for the methods
        $connectionMock->method('getDatabasePlatform')->willReturn($platformMock);
        $this->entityManagerMock->method('getConnection')->willReturn($connectionMock);

        $this->entityManagerMock->method('getRepository')->willReturnMap([
            [PopulationPerLan::class, $this->populationPerLanRepositoryMock],
            [LanElomrade::class, $this->lanElomradeRepositoryMock],
        ]);

        $this->populationElomradeService = new PopulationElomradeService($this->entityManagerMock);
    }

    public function testCalculateAndSavePopulationPerElomrade()
    {
        // Mocking the PopulationPerLan data
        $populationData1 = $this->createMock(PopulationPerLan::class);
        $populationData1->method('getYear')->willReturn(2020);
        $populationData1->method('getStockholm')->willReturn(1000000);
        $populationData1->method('getUppsala')->willReturn(200000);
        $populationData1->method('getNorrbotten')->willReturn(249614);  // Include Norrbotten for SE1

        $populationData2 = $this->createMock(PopulationPerLan::class);
        $populationData2->method('getYear')->willReturn(2020);
        $populationData2->method('getVasterbotten')->willReturn(300000);

        $populationData3 = $this->createMock(PopulationPerLan::class);
        $populationData3->method('getYear')->willReturn(2020);
        $populationData3->method('getGotland')->willReturn(100000);

        $populationData4 = $this->createMock(PopulationPerLan::class);
        $populationData4->method('getYear')->willReturn(2020);
        $populationData4->method('getBlekinge')->willReturn(120000);

        // Setting up the repository mocks to return the mock data
        $this->populationPerLanRepositoryMock->method('findAll')->willReturn([$populationData1, $populationData2, $populationData3, $populationData4]);

        // Adding SE1 mapping to the LanElomrade mock data
        $lanElomradeData1 = $this->createMock(LanElomrade::class);
        $lanElomradeData1->method('getLan')->willReturn('Stockholms län');
        $lanElomradeData1->method('getElomrade')->willReturn('SE3');

        $lanElomradeData2 = $this->createMock(LanElomrade::class);
        $lanElomradeData2->method('getLan')->willReturn('Uppsala län');
        $lanElomradeData2->method('getElomrade')->willReturn('SE3');

        $lanElomradeData3 = $this->createMock(LanElomrade::class);
        $lanElomradeData3->method('getLan')->willReturn('Västerbottens län');
        $lanElomradeData3->method('getElomrade')->willReturn('SE2');

        $lanElomradeData4 = $this->createMock(LanElomrade::class);
        $lanElomradeData4->method('getLan')->willReturn('Gotlands län');
        $lanElomradeData4->method('getElomrade')->willReturn('SE4');

        $lanElomradeData5 = $this->createMock(LanElomrade::class);
        $lanElomradeData5->method('getLan')->willReturn('Norrbottens län');  // Mapping for SE1
        $lanElomradeData5->method('getElomrade')->willReturn('SE1');

        $this->lanElomradeRepositoryMock->method('findAll')->willReturn([$lanElomradeData1, $lanElomradeData2, $lanElomradeData3, $lanElomradeData4, $lanElomradeData5]);

        // Expect the entity manager's persist method to be called five times (including SE1)
        $this->entityManagerMock->expects($this->exactly(4))
            ->method('persist')
            ->with($this->isInstanceOf(PopulationPerElomrade::class));

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        // Run the method under test
        $this->populationElomradeService->calculateAndSavePopulationPerElomrade();
    }

    public function testEnsureStringThrowsExceptionOnInvalidValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is null, expected a valid string");

        // Testar direkt den nu publika metoden ensureString
        $this->populationElomradeService->ensureString(null);
    }

    public function testEnsureIntThrowsExceptionOnInvalidValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid integer");

        // Testar direkt den nu publika metoden ensureInt
        $this->populationElomradeService->ensureInt('invalid');
    }

    public function testConvertLanToPropertyReturnsEmptyStringOnUnknownLan()
    {
        $result = $this->populationElomradeService->convertLanToProperty('Unknown län');
        $this->assertEquals('', $result);
    }

    public function testCalculateAndSavePopulationPerElomradeWithEmptyData()
    {
        // Mock tomma resultat från repository
        $this->populationPerLanRepositoryMock->method('findAll')->willReturn([]);
        $this->lanElomradeRepositoryMock->method('findAll')->willReturn([]);

        // Förvänta att inga metoder för persist eller flush anropas
        $this->entityManagerMock->expects($this->never())->method('persist');
        $this->entityManagerMock->expects($this->never())->method('flush');

        $this->populationElomradeService->calculateAndSavePopulationPerElomrade();
    }
}
