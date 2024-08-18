<?php
namespace App\Factory;

use App\Entity\LanElomrade;
use InvalidArgumentException;

class LanElomradeFactory
{
    public function create(array $data): ?LanElomrade
    {

        if ($data[0] === null) {
            echo "Skipping row due to missing year in PopulationPerLan.\n";
            return null;
        }

        $entity = new LanElomrade();
        $entity->setLan($this->ensureString($data[0]));
        $entity->setElomrade($this->ensureString($data[1]));
        return $entity;
    }

    private function ensureString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if ($value === null) {
            throw new InvalidArgumentException("Value is null, expected a valid string.");
        }

        throw new InvalidArgumentException("Value is not a valid string: " . print_r($value, true));
    }
}
