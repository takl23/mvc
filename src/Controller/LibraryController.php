<?php 

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        // Tell Doctrine you want to save the library
        $entityManager->persist($library);

        // Execute the queries (i.e. the INSERT query)
        $entityManager->flush();

        // Add a flash message
        $this->addFlash('notice', 'Saved new book with id ' . $library->getId());

        // Redirect to the library route
        return $this->redirectToRoute('app_library');
    }
    
    #[Route('/library/show', name: 'view_library')]
    public function viewLibrary(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository->findAll();

        $data = [
            'library' => $library
        ];

        return $this->render('library/view.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'book_by_id')]
    public function showBookById(
    LibraryRepository $libraryRepository, int $id
    ): Response {
    $book = $libraryRepository
        ->find($id);

        // $data = [
        //     'book' => $book
        // ];
        
    return $this->json($book);
    }
}
