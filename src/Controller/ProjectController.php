<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route("/proj", name: "proj")]
    public function index(): Response
    {
        return $this->render('proj/index.html.twig');
    }

    #[Route("/proj/home", name: "proj_home")]
    public function home(): Response
    {
        return $this->render('proj/home.html.twig');
    }

    #[Route("/proj/about", name: "proj_about")]
    public function about(): Response
    {
        return $this->render('proj/about.html.twig');
    }

    #[Route("/proj/goal", name: "proj_goal")]
    public function goal(): Response
    {
        return $this->render('proj/goal.html.twig');
    }

    #[Route("/proj/json", name: "proj_json")]
    public function projectJson(): Response
    {
        return $this->render('proj/json_links.html.twig');
    }
}
