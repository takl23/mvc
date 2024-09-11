<?php

namespace App\Controller;

use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

date_default_timezone_set("Europe/Stockholm");

class LibraryControllerJson extends AbstractController
{
    #[Route('/api/library/books', name: 'api_library_books')]
    public function showAllLibraryBooks(LibraryRepository $libraryRepository): JsonResponse
    {
        $libraries = $libraryRepository->findAll();

        $response = $this->json($libraries);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/library/book/{isbn}', name: 'api_library_book_by_isbn')]
    public function showBookByIsbn(LibraryRepository $libraryRepository, string $isbn): JsonResponse
    {
        $book = $libraryRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            return $this->json(['error' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
