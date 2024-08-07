<?php
// src/Controller/ProjectController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LanElomrade;
use Doctrine\ORM\EntityManagerInterface;

class ProjectController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
        $repository = $this->entityManager->getRepository(LanElomrade::class);
        $lanElomrade = $repository->findAll();

        $groupedData = [];
        foreach ($lanElomrade as $item) {
            $groupedData[$item->getElomrade()][] = $item->getLan();
        }

        return $this->render('proj/goal.html.twig', [
            'groupedData' => $groupedData,
        ]);
    }

    #[Route("/proj/api", name: "proj_json")]
    public function projectJson(): Response
    {
        return $this->render('proj/json_links.html.twig');
    }
}
