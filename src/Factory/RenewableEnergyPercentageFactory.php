<?php

namespace App\Factory;

use App\Entity\RenewableEnergyPercentage;
use InvalidArgumentException;


class RenewableEnergyPercentageFactory
{
    public function create(array $data): RenewableEnergyPercentage
    {
        $entity = new RenewableEnergyPercentage();
        
        // Här antar jag att din data har följande struktur, justera efter behov
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setVIM($this->ensureInt($data[1]));
        $entity->setEl($this->ensureInt($data[2]));
        $entity->setTransport($this->ensureInt($data[3]));
        $entity->setTotal($this->ensureInt($data[4]));

        return $entity;
    }

    private function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int) $value;
        }
        throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
    }
}
