<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/report", name: "report")]
    public function home(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/", name: "me")]
    public function mepage(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }



    #[Route("/links", name: "links")]
    public function links(): Response
    {
        return $this->render('links.html.twig');
    }

    #[Route("/docs", name: "docs")]
    public function docs(): Response
    {
        return $this->redirect('/docs/api/index.html');
    }

    #[Route("/docs/metrics", name: "metrics_docs")]
    public function metricsDocs(): Response
    {
        // Här dirigerar vi direkt till indexfilen i din metrics dokumentation
        return $this->redirect('/docs/metrics/index.html');
    }
}
