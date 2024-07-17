<?php
namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Library;

/**
 * Test cases for class Library.
 */
class LibraryTest extends TestCase
{
    /**
     * Test getId and ensure it returns null for a new entity
     */
    public function testGetId(): void
    {
        $library = new Library();
        $this->assertNull($library->getId());
    }

    /**
     * Test setting and getting the title
     */
    public function testSetAndGetTitle(): void
    {
        $library = new Library();
        $title = 'Test Title';

        $library->setTitle($title);
        $this->assertSame($title, $library->getTitle());
    }

    /**
     * Test setting and getting the ISBN
     */
    public function testSetAndGetISBN(): void
    {
        $library = new Library();
        $isbn = '1234567890123';

        $library->setISBN($isbn);
        $this->assertSame($isbn, $library->getISBN());
    }

    /**
     * Test setting and getting the author
     */
    public function testSetAndGetAuthor(): void
    {
        $library = new Library();
        $author = 'Test Author';

        $library->setAuthor($author);
        $this->assertSame($author, $library->getAuthor());
    }

    /**
     * Test setting and getting the cover
     */
    public function testSetAndGetCover(): void
    {
        $library = new Library();
        $cover = 'Test Cover';

        $library->setCover($cover);
        $this->assertSame($cover, $library->getCover());
    }
}
