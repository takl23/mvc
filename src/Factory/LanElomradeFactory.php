<?php

namespace App\Factory;

use App\Entity\LanElomrade;
use InvalidArgumentException;

class LanElomradeFactory
{
    /**
     * Create a LanElomrade entity from an array of data.
     *
     * @param array<int, mixed> $data The data used to create the entity.
     * @return LanElomrade|null
     */
    public function create(array $data): ?LanElomrade
    {
        if ($data[0] === null || $data[1] === null || $data[0] === '' || $data[1] === '') {
            throw new InvalidArgumentException("Missing required data for 'lan' or 'elomrade'.");
        }

        $entity = new LanElomrade();
        $entity->setLan($this->ensureString($data[0]));
        $entity->setElomrade($this->ensureString($data[1]));
        return $entity;
    }

    /**
     * Ensure the value is a valid string.
     *
     * @param mixed $value
     * @return string
     * @throws InvalidArgumentException
     */
    private function ensureString(mixed $value): string
    {
        if (is_string($value) && $value !== '') {
            return $value;
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        throw new InvalidArgumentException("Value is not a valid string: " . print_r($value, true));
    }
}
