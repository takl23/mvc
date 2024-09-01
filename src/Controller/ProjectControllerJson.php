<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\RenewableEnergyTWh;
use App\Entity\EnergySupplyGDP;
use App\Entity\AverageConsumption;
use App\Entity\ElectricityPrice;
use App\Entity\LanElomrade;
use App\Entity\PopulationPerElomrade;
use App\Entity\ConsumptionPerCapita;
use App\Entity\AverageAnnualCostPerPerson;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ElectricityPriceRepository;

class ProjectControllerJson extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/api/renewable-energy", name: "api_renewable_energy_json")]
    public function index(): JsonResponse
    {
        return $this->generateJsonResponse(
            RenewableEnergyPercentage::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'vim' => $item->getVIM(),
                    'el' => $item->getEl(),
                    'transport' => $item->getTransport(),
                    'total' => $item->getTotal(),
                ];
            },
            'https://www.sverigesmiljomal.se/miljomalen/generationsmalet/fornybar-energi/'
        );
    }

    #[Route("/api/renewable_energy_twh", name: "api_renewable_energy_twh")]
    public function renewableEnergyTWh(): JsonResponse
    {
        return $this->generateJsonResponse(
            RenewableEnergyTWh::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'biofuels' => $item->getBiofuels(),
                    'hydropower' => $item->getHydropower(),
                    'windPower' => $item->getWindPower(),
                    'heatPump' => $item->getHeatPump(),
                    'solarEnergy' => $item->getSolarEnergy(),
                    'total' => $item->getTotal(),
                    'statTransferToNorway' => $item->getStatTransferToNorway(),
                    'renewableEnergyInTargetCalculation' => $item->getRenewableEnergyInTargetCalculation(),
                    'totalEnergyUse' => $item->getTotalEnergyUse(),
                ];
            },
            'https://www.scb.se/hitta-statistik/temaomraden/agenda-2030/mal-7/#141072'
        );
    }

    #[Route("/api/energy_supply_gdp", name: "api_energy_supply_gdp")]
    public function energySupplyGDP(): JsonResponse
    {
        return $this->generateJsonResponse(
            EnergySupplyGDP::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'precentage' => $item->getPrecentage(),
                ];
            },
            'https://www.scb.se/hitta-statistik/temaomraden/agenda-2030/mal-7/'
        );
    }

    #[Route("/api/average-consumption", name: "api_average_consumption")]
    public function averageConsumption(): JsonResponse
    {
        return $this->generateJsonResponse(
            AverageConsumption::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'se1' => $item->getse1(),
                    'se2' => $item->getse2(),
                    'se3' => $item->getse3(),
                    'se4' => $item->getse4(),
                ];
            },
            'https://www.statistikdatabasen.scb.se/pxweb/sv/ssd/START__EN__EN0105__EN0105A/ElAnvSNI2007ArN/table/tableViewLayout1/'
        );
    }

    #[Route("/api/electricity-price", name: "api_electricity_price")]
    public function electricityPrice(): JsonResponse
    {
        return $this->generateJsonResponse(
            ElectricityPrice::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'se1' => $item->getse1(),
                    'se2' => $item->getse2(),
                    'se3' => $item->getse3(),
                    'se4' => $item->getse4(),
                ];
            },
            'https://data.nordpoolgroup.com/auction/day-ahead/prices?deliveryDate=latest&currency=SEK&aggregation=Yearly&deliveryAreas=se1,se2,se3,se4'
        );
    }

    #[Route("/api/lan-elomrade", name: "api_lan_elomrade")]
    public function lanElomrade(): JsonResponse
    {
        return $this->generateJsonResponse(
            LanElomrade::class,
            function ($item) {
                return [
                    'lan' => $item->getLan(),
                    'elomrade' => $item->getElomrade(),
                ];
            },
            'https://elavtaldirekt.se/elmarknad/elomraden/'
        );
    }

    #[Route("/api/population-per-elomrade", name: "api_population_per_elomrade")]
    public function populationPerElomrade(): JsonResponse
    {
        return $this->generateJsonResponse(
            PopulationPerElomrade::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'elomrade' => $item->getElomrade(),
                    'population' => $item->getPopulation(),
                ];
            },
            'https://www.scb.se/'
        );
    }

    #[Route("/api/consumption-per-capita", name: "api_consumption_per_capita")]
    public function consumptionPerCapita(): JsonResponse
    {
        return $this->generateJsonResponse(
            ConsumptionPerCapita::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'elomrade' => $item->getElomrade(),
                    'consumptionPerCapita' => $item->getConsumptionPerCapita(),
                ];
            },
            'https://www.scb.se/'
        );
    }

    #[Route("/api/annual-cost-per-person", name: "api_annual_cost_per_person")]
    public function annualCostPerPerson(): JsonResponse
    {
        return $this->generateJsonResponse(
            AverageAnnualCostPerPerson::class,
            function ($item) {
                return [
                    'year' => $item->getYear(),
                    'elomrade' => $item->getElomrade(),
                    'annualCost' => $item->getAverageCostPerPerson(),
                ];
            },
            'https://www.scb.se/'
        );
    }

    #[Route("/api/calculate-electricity-cost", name: "api_calculate_electricity_cost", methods: ["POST"])]
    public function calculateElectricityCost(Request $request, ElectricityPriceRepository $electricityPriceRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Invalid JSON data.'
            ], 400);
        }

        $elomrade = $data['elomrade'] ?? null;
        $consumption = $data['consumption'] ?? null;

        if (!$elomrade || !$consumption) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Missing required parameters: elomrade and/or consumption'
            ], 400);
        }

        $electricityPrice = $electricityPriceRepository->findOneBy([], ['year' => 'DESC']);

        if (!$electricityPrice) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Electricity price data not found.'
            ], 404);
        }

        $pricePerKwh = match ($elomrade) {
            'se1' => $electricityPrice->getse1(),
            'se2' => $electricityPrice->getse2(),
            'se3' => $electricityPrice->getse3(),
            'se4' => $electricityPrice->getse4(),
            default => null,
        };

        if ($pricePerKwh === null) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Invalid elomrade specified.'
            ], 400);
        }

        $cost = $consumption * $pricePerKwh;

        return new JsonResponse([
            'elomrade' => $elomrade,
            'year' => $electricityPrice->getYear(),
            'price_per_kwh' => $pricePerKwh,
            'consumption' => $consumption,
            'total_cost' => $cost
        ]);
    }

    /**
     * @param string $entityClass Namnet på entitetsklassen som ska hämtas från databasen.
     * @param callable $formatter En callback-funktion för att formatera varje enskild entitet.
     * @param string $reference En URL eller referens som ska inkluderas i JSON-svaret.
     * @return JsonResponse
     */
    private function generateJsonResponse(string $entityClass, callable $formatter, string $reference): JsonResponse
{
    // Ensure the entity class exists and is a valid class-string
    assert(class_exists($entityClass), sprintf('Class %s does not exist.', $entityClass));

    $repository = $this->entityManager->getRepository($entityClass);
    $data = $repository->findAll();

    $formattedData = array_map($formatter, $data);

    $response = new JsonResponse([
        'data' => $formattedData,
        'reference' => $reference,
        'date' => 'August 2024'
    ]);

    $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

    return $response;
}

}
