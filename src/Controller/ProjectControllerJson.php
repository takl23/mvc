<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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


class ProjectControllerJson extends AbstractController
{
    #[Route("/api/renewable-energy", name: "api_renewable_energy_json")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(RenewableEnergyPercentage::class);
        $data = $repository->findAll();

        $formattedData = array_map(function ($item) {
            return [
                'year' => $item->getYear(),
                'vim' => $item->getVIM(),
                'el' => $item->getEl(),
                'transport' => $item->getTransport(),
                'total' => $item->getTotal(),
            ];
        }, $data);

        $responseData = [
            'data' => $formattedData,
            'reference1' => 'https://www.sverigesmiljomal.se/miljomalen/generationsmalet/fornybar-energi/',
            'reference2' => 'https://www.scb.se/hitta-statistik/temaomraden/agenda-2030/mal-7/#141072',
            'date' => 'August 2024'
        ];

        $response = new JsonResponse($responseData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/renewable_energy_twh", name: "api_renewable_energy_twh")]
    public function renewableEnergyTWh(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(RenewableEnergyTWh::class);
        $data = $repository->findAll();
    
        $formattedData = array_map(function ($item) {
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
        }, $data);
    
        $response = new JsonResponse([
            'data' => $formattedData,
            'reference' => 'https://www.scb.se/hitta-statistik/temaomraden/agenda-2030/mal-7/#141072',
            'date' => 'August 2024'
        ]);
        
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
    
        return $response;
    }

    #[Route("/api/energy_supply_gdp", name: "api_energy_supply_gdp")]
    public function energySupplyGDP(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(EnergySupplyGDP::class);
        $data = $repository->findAll();

        $formattedData = array_map(function ($item) {
            return [
                'year' => $item->getYear(),
                'precentage' => $item->getPrecentage(),
            ];
        }, $data);

        $response = new JsonResponse([
            'data' => $formattedData,
            'reference' => 'https://www.scb.se/hitta-statistik/temaomraden/agenda-2030/mal-7/',
            'date' => 'August 2024'
        ]);
        
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }


    #[Route("/api/average-consumption", name: "api_average_consumption")]
    public function averageConsumption(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(AverageConsumption::class);
        $data = $repository->findAll();

        $formattedData = array_map(function ($item) {
            return [
                'year' => $item->getYear(),
                'SE1' => $item->getSE1(),
                'SE2' => $item->getSE2(),
                'SE3' => $item->getSE3(),
                'SE4' => $item->getSE4(),
            ];
        }, $data);

        $response = new JsonResponse([
            'data' => $formattedData,
            'reference' => 'https://www.statistikdatabasen.scb.se/pxweb/sv/ssd/START__EN__EN0105__EN0105A/ElAnvSNI2007ArN/table/tableViewLayout1/',
            'date' => 'August 2024'
        ]);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }

    #[Route("/api/electricity-price", name: "api_electricity_price")]
public function electricityPrice(EntityManagerInterface $entityManager): JsonResponse
{
    $repository = $entityManager->getRepository(ElectricityPrice::class);
    $data = $repository->findAll();

    $formattedData = array_map(function ($item) {
        return [
            'year' => $item->getYear(),
            'SE1' => $item->getSE1(),
            'SE2' => $item->getSE2(),
            'SE3' => $item->getSE3(),
            'SE4' => $item->getSE4(),
        ];
    }, $data);

    $response = new JsonResponse([
        'data' => $formattedData,
        'reference' => 
        'https://data.nordpoolgroup.com/auction/day-ahead/prices?deliveryDate=latest&currency=SEK&aggregation=Yearly&deliveryAreas=SE1,SE2,SE3,SE4',
        'date' => 'August 2024'
    ]);

    $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

    return $response;
}

#[Route("/api/lan-elomrade", name: "api_lan_elomrade")]
    public function lanElomrade(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(LanElomrade::class);
        $data = $repository->findAll();

        $formattedData = array_map(function ($item) {
            return [
                'lan' => $item->getLan(),
                'elomrade' => $item->getElomrade(),
            ];
        }, $data);

        $response = new JsonResponse([
            'data' => $formattedData,
            'reference' => 'https://elavtaldirekt.se/elmarknad/elomraden/',
            'date' => 'August 2024'
        ]);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }
    #[Route("/api/population-per-elomrade", name: "api_population_per_elomrade")]
    public function populationPerElomrade(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(PopulationPerElomrade::class);
        $data = $repository->findAll();

        $formattedData = array_map(function ($item) {
            return [
                'year' => $item->getYear(),
                'elomrade' => $item->getElomrade(),
                'population' => $item->getPopulation(),
            ];
        }, $data);

        $response = new JsonResponse([
            'data' => $formattedData,
            'reference' => 'https://www.scb.se/',
            'date' => 'August 2024'
        ]);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }

    #[Route("/api/consumption-per-capita", name: "api_consumption_per_capita")]
    public function consumptionPerCapita(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(ConsumptionPerCapita::class);
        $data = $repository->findAll();

        $formattedData = array_map(function ($item) {
            return [
                'year' => $item->getYear(),
                'elomrade' => $item->getElomrade(),
                'consumptionPerCapita' => $item->getConsumptionPerCapita(),
            ];
        }, $data);

        $response = new JsonResponse([
            'data' => $formattedData,
            'reference' => 'https://www.scb.se/',
            'date' => 'August 2024'
        ]);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }

    #[Route("/api/annual-cost-per-person", name: "api_annual_cost_per_person")]
public function annualCostPerPerson(EntityManagerInterface $entityManager): JsonResponse
{
    $repository = $entityManager->getRepository(AverageAnnualCostPerPerson::class);
    $data = $repository->findAll();

    $formattedData = array_map(function ($item) {
        return [
            'year' => $item->getYear(),
            'elomrade' => $item->getElomrade(),
            'annualCost' => $item->getAverageCostPerPerson(),
        ];
    }, $data);

    $response = new JsonResponse(['data' => $formattedData]);
    
    $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

    return $response;
}

}
