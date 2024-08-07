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
use App\Entity\AverageTemperature;
use App\Entity\AverageConsumption;
use App\Entity\ElectricityPrice;
use App\Entity\LanElomrade;

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
            'instructions' => 'Gå till URL. Välj "Generationsmålet". Ladda ner data som Excel-fil.',
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
            'instructions' => 'Gå till URL. Välj "Agenda 2030". Välj "Mål 7". Ladda ner data som Excel-fil.',
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
            'instructions' => 'Gå till URL. Välj "Agenda 2030". Välj "Mål 7". Ladda ner data som Excel-fil.',
            'date' => 'August 2024'
        ]);
        
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }

    #[Route("/api/average-temperature", name: "api_average_temperature")]
    public function averageTemperature(EntityManagerInterface $entityManager): JsonResponse
    {
        $repository = $entityManager->getRepository(AverageTemperature::class);
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
            'reference' => 'https://www.smhi.se/data/meteorologi/temperatur/',
            'instructions' => 'Gå till URL. Välj "Temperaturdata". Välj elområde och tidsperiod (2015-2023). Ladda ner data som Excel-fil.',
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
            'reference' => 'https://www.energimyndigheten.se/statistik/',
            'instructions' => 'Gå till URL. Välj "Elförbrukning". Välj elområde och tidsperiod (2015-2023). Ladda ner data som Excel-fil.',
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
            'reference' => 'https://www.ei.se/sv/statistik/',
            'instructions' => 'Gå till URL. Välj "Elprisstatistik". Välj elområde och tidsperiod (2015-2023). Ladda ner data som Excel-fil.',
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
            'reference' => 'https://www.energimyndigheten.se/statistik/',
            'instructions' => 'Gå till URL. Välj "Elområden". Ladda ner data som Excel-fil.',
            'date' => 'August 2024'
        ]);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }
}
