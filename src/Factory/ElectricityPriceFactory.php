<?php

namespace App\Factory;

use App\Entity\ElectricityPrice;
use InvalidArgumentException;

class ElectricityPriceFactory
{
    /**
     * Create an ElectricityPrice entity from an array of data.
     *
     * @param array<int, mixed> $data The data used to create the entity.
     * @return ElectricityPrice
     */
    public function create(array $data): ElectricityPrice
    {
        if ($data[0] === null) {
            throw new InvalidArgumentException("Year is missing, cannot create ElectricityPrice entity.");
        }

        if (!$this->isValidPriceData($data)) {
            throw new InvalidArgumentException("Invalid price data provided.");
        }

        $entity = new ElectricityPrice();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setSe1($this->ensureFloat($data[1]));
        $entity->setSe2($this->ensureFloat($data[2]));
        $entity->setSe3($this->ensureFloat($data[3]));
        $entity->setSe4($this->ensureFloat($data[4]));
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
        if (isset($value) && is_numeric($value)) {
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

    /**
     * Validate that the price data array contains valid numeric values.
     *
     * @param array<int, mixed> $data
     * @return bool
     */
    public function isValidPriceData(array $data): bool
    {
        return isset($data[1], $data[2], $data[3], $data[4]) &&
               is_numeric($data[1]) && is_numeric($data[2]) &&
               is_numeric($data[3]) && is_numeric($data[4]);
    }
}
