<?php
namespace App\Factory;

use App\Entity\EnergySupplyGDP;
use InvalidArgumentException;

class EnergySupplyGDPFactory
{
    public function create(array $data): EnergySupplyGDP
    {
        $entity = new EnergySupplyGDP();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setPrecentage($this->ensureFloat($data[1]));

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
}
