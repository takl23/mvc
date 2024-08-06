<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RenewableEnergyPercentage;
use App\Entity\RenewableEnergyTWh;
use App\Entity\EnergySupplyGDP;
use Doctrine\ORM\EntityManagerInterface;

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
}
