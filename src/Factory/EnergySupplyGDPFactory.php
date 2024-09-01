<?php

namespace App\Factory;

use App\Entity\EnergySupplyGDP;
use InvalidArgumentException;

class EnergySupplyGDPFactory
{
    /**
    * Create an EnergySupplyGDP entity from an array of data.
    *
    * @param array<int, mixed> $data The data used to create the entity.
    * @return EnergySupplyGDP
    */
    public function create(array $data): EnergySupplyGDP
    {
        $entity = new EnergySupplyGDP();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setPrecentage($this->ensureFloat($data[1]));

        return $entity;
    }


    /**
         * Ensure the value is a valid float.
         *
         * @param mixed $value
         * @return float
         * @throws InvalidArgumentException
         */
    public function ensureFloat(mixed $value): float
    {
        if (isset($value) && is_numeric(str_replace(',', '.', $value))) {
            return (float) str_replace(',', '.', (string) $value);
        }
        throw new InvalidArgumentException("Value is not a valid float: " . print_r($value, true));
    }


    /**
     * Ensure the value is a valid integer.
     *
     * @param mixed $value
     * @return int
     * @throws InvalidArgumentException
     */
    public function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int) $value;
        }
        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }
}
