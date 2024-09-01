<?php

namespace App\Factory;

use App\Entity\RenewableEnergyPercentage;
use InvalidArgumentException;

class RenewableEnergyPercentageFactory
{
    /**
     * Create a RenewableEnergyPercentage entity from an array of data.
     *
     * @param array<int, mixed> $data The data used to create the entity.
     * @return RenewableEnergyPercentage
     */
    public function create(array $data): RenewableEnergyPercentage
    {
        $entity = new RenewableEnergyPercentage();

        // Anpassa efter din datastruktur
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setVIM($this->ensureNullableInt($data[1]));
        $entity->setEl($this->ensureNullableInt($data[2]));
        $entity->setTransport($this->ensureNullableInt($data[3]));
        $entity->setTotal($this->ensureNullableInt($data[4]));

        return $entity;
    }

    /**
     * Ensures that a value is an integer.
     *
     * @param mixed $value The value to ensure is an integer.
     * @return int
     * @throws InvalidArgumentException if the value is not a valid integer.
     */
    public function ensureInt(mixed $value): int
    {
        if ($value === null || $value === '') {
            throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }

    /**
     * Ensures that a value is a nullable integer.
     *
     * @param mixed $value The value to ensure is a nullable integer.
     * @return int|null
     * @throws InvalidArgumentException if the value is not a valid nullable integer.
     */
    public function ensureNullableInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        throw new InvalidArgumentException("Value is not a valid nullable integer: " . print_r($value, true));
    }
}
