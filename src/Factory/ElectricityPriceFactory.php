<?php
namespace App\Factory;

use App\Entity\ElectricityPrice;
use InvalidArgumentException;

class ElectricityPriceFactory
{
    public function create(array $data): ?ElectricityPrice
    {
        if ($data[0] === null || !$this->isValidPriceData($data)) {
            echo "Skipping row due to missing or invalid values in ElectricityPrice.\n";
            return null;
        }

        $entity = new ElectricityPrice();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setSe1($this->ensureFloat($data[1]));
        $entity->setSe2($this->ensureFloat($data[2]));
        $entity->setSe3($this->ensureFloat($data[3]));
        $entity->setSe4($this->ensureFloat($data[4]));
        return $entity;
    }

    private function ensureFloat(mixed $value): float
    {
        if (isset($value) && is_numeric($value)) {
            return (float) str_replace(',', '.', (string) $value);
        }
        throw new InvalidArgumentException("Value is not a valid float: " . print_r($value, true));
    }

    private function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int) $value;
        }
        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }

    private function isValidPriceData(array $data): bool
    {
        return isset($data[1], $data[2], $data[3], $data[4]) &&
               is_numeric($data[1]) && is_numeric($data[2]) &&
               is_numeric($data[3]) && is_numeric($data[4]);
    }
}
