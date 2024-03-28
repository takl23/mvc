<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

date_default_timezone_set("Europe/Stockholm");

class LuckyControllerJson
{
       #[Route("/api/lucky/number", name: "luckynumber")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

          // return new JsonResponse($data);

          $response = new JsonResponse($data);
          $response->setEncodingOptions(
              $response->getEncodingOptions() | JSON_PRETTY_PRINT
          );
          return $response;
    }

    #[Route("/api/qoute", name: "qoute")]
    public function jsonQoute(): Response
    {
        $qoute = array("Seize the day", "Today will be a good day", "You are amazing", "You are awesome");
        shuffle($qoute);
        
        $data = [
            'Random qoute selected for you' => $qoute[0],
            'Todays date' => date("Y-m-d"), 
            'Time Europe/Stockholm' => date("H:i:s"), 
        ];

          // return new JsonResponse($data);

          $response = new JsonResponse($data);
          $response->setEncodingOptions(
              $response->getEncodingOptions() | JSON_PRETTY_PRINT
          );
          return $response;
    }


    
}
