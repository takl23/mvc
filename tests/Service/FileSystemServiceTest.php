<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\FileSystemService;

class FileSystemServiceTest extends TestCase
{
    private FileSystemService $fileSystemService;

    protected function setUp(): void
    {
        $this->fileSystemService = new FileSystemService();
    }

    public function testFileExistsWithExistingFile(): void
    {
        // Skapa en temporär fil
        $tempFile = tempnam(sys_get_temp_dir(), 'test_file');
        $this->assertFileExists($tempFile); // Säkerställ att filen skapades

        // Testa att fileExists returnerar true för den existerande filen
        $this->assertTrue($this->fileSystemService->fileExists($tempFile));

        // Ta bort den temporära filen
        unlink($tempFile);
    }

    public function testFileExistsWithNonExistingFile(): void
    {
        // Testa att fileExists returnerar false för en icke-existerande fil
        $this->assertFalse($this->fileSystemService->fileExists('/path/to/non/existent/file'));
    }
}
