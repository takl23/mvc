<?php
namespace App\Factory;

use App\Entity\AverageConsumption;
use InvalidArgumentException; 

class AverageConsumptionFactory
{
    public function create(array $data): AverageConsumption
    {
        $entity = new AverageConsumption();
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
}
