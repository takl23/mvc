<?php

namespace App\Controller;


use App\Entity\Library;
use Doctrine\Persistence\ManagerRegistry;
use PharIo\Manifest\Library as ManifestLibrary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/library/create', name: 'library_create_post', methods: ['POST'])]
    public function createLibrary(
    ManagerRegistry $doctrine, 
    Request $request
    ): Response {

        $newLibrary = [
            'title' => $request->request->get('title'),
            'author' => $request->request->get('author'),
            'isbn' => $request->request->get('isbn'),
            'cover' => $request->request->get('cover')
            ];  
        
    $entityManager = $doctrine->getManager();

    $library = new Library();
    $library->setTitle($newLibrary['title']);
    $library->setAuthor($newLibrary['author']);
    $library->setIsbn($newLibrary['isbn']);
    $library->setCover($newLibrary['cover']);

    // tell Doctrine you want to (eventually) save the Product
    // (no queries yet)
    $entityManager->persist($library);

    // actually executes the queries (i.e. the INSERT query)
    $entityManager->flush();

    return new Response('Saved new Library with id '.$library->getId());
    }
    
    
}
