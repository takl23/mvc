<?php

namespace App\Service;

class FileSystemService
{
    public function fileExists(string $filePath): bool
    {
        return file_exists($filePath);
    }
}
