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
    /** 
     * @var \Doctrine\ORM\EntityManagerInterface&\PHPUnit\Framework\MockObject\MockObject 
     */
    private $entityManagerMock;


    /** @var MockObject&EntityRepository<PopulationPerLan> */
    private $populationPerLanRepositoryMock;

    /** @var MockObject&EntityRepository<LanElomrade> */
    private $lanElomradeRepositoryMock;

    /** @var PopulationElomradeService */
    private $populationElomradeService;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->populationPerLanRepositoryMock = $this->createMock(EntityRepository::class);
        $this->lanElomradeRepositoryMock = $this->createMock(EntityRepository::class);

        $connectionMock = $this->createMock(Connection::class);
        $platformMock = $this->createMock(AbstractPlatform::class);

        $connectionMock->method('getDatabasePlatform')->willReturn($platformMock);
        $this->entityManagerMock->method('getConnection')->willReturn($connectionMock);

        $this->entityManagerMock->method('getRepository')->willReturnMap([
            [PopulationPerLan::class, $this->populationPerLanRepositoryMock],
            [LanElomrade::class, $this->lanElomradeRepositoryMock],
        ]);

        $this->populationElomradeService = new PopulationElomradeService($this->entityManagerMock);
    }

    public function testCalculateAndSavePopulationPerElomrade(): void
    {
        // Mocking the PopulationPerLan data
        $populationData1 = $this->createMock(PopulationPerLan::class);
        $populationData1->method('getYear')->willReturn(2020);
        $populationData1->method('getStockholm')->willReturn(1000000);
        $populationData1->method('getUppsala')->willReturn(200000);
        $populationData1->method('getNorrbotten')->willReturn(249614);

        $populationData2 = $this->createMock(PopulationPerLan::class);
        $populationData2->method('getYear')->willReturn(2020);
        $populationData2->method('getVasterbotten')->willReturn(300000);

        $populationData3 = $this->createMock(PopulationPerLan::class);
        $populationData3->method('getYear')->willReturn(2020);
        $populationData3->method('getGotland')->willReturn(100000);

        $populationData4 = $this->createMock(PopulationPerLan::class);
        $populationData4->method('getYear')->willReturn(2020);
        $populationData4->method('getBlekinge')->willReturn(120000);

        $this->populationPerLanRepositoryMock->method('findAll')->willReturn([$populationData1, $populationData2, $populationData3, $populationData4]);

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
        $lanElomradeData5->method('getLan')->willReturn('Norrbottens län');
        $lanElomradeData5->method('getElomrade')->willReturn('SE1');

        $this->lanElomradeRepositoryMock->method('findAll')->willReturn([$lanElomradeData1, $lanElomradeData2, $lanElomradeData3, $lanElomradeData4, $lanElomradeData5]);

        $this->entityManagerMock->expects($this->exactly(4))
            ->method('persist')
            ->with($this->isInstanceOf(PopulationPerElomrade::class));

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->populationElomradeService->calculateAndSavePopulationPerElomrade();
    }

    public function testEnsureStringThrowsExceptionOnInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is null, expected a valid string");

        $this->populationElomradeService->ensureString(null);
    }

    public function testEnsureIntThrowsExceptionOnInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value is not a valid integer");

        $this->populationElomradeService->ensureInt('invalid');
    }

    public function testConvertLanToPropertyReturnsEmptyStringOnUnknownLan(): void
    {
        $result = $this->populationElomradeService->convertLanToProperty('Unknown län');
        $this->assertEquals('', $result);
    }

    public function testCalculateAndSavePopulationPerElomradeWithEmptyData(): void
    {
        $this->populationPerLanRepositoryMock->method('findAll')->willReturn([]);
        $this->lanElomradeRepositoryMock->method('findAll')->willReturn([]);

        $this->entityManagerMock->expects($this->never())->method('persist');
        $this->entityManagerMock->expects($this->never())->method('flush');

        $this->populationElomradeService->calculateAndSavePopulationPerElomrade();
    }
}
