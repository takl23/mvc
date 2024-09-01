<?php

namespace App\Factory;

use App\Entity\RenewableEnergyTWh;
use InvalidArgumentException;

class RenewableEnergyTWhFactory
{
    /**
 * Create a RenewableEnergyTWh entity from an array of data.
 *
 * @param array<int, mixed> $data The data used to create the entity.
 * @return RenewableEnergyTWh
 */
    public function create(array $data): RenewableEnergyTWh
    {

        echo "Data received in create method: " . print_r($data, true) . "\n";
        $entity = new RenewableEnergyTWh();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setBiofuels($this->ensureNullableInt($data[1]));
        $entity->setHydropower($this->ensureNullableInt($data[2]));
        $entity->setWindPower($this->ensureNullableInt($data[3]));
        $entity->setHeatPump($this->ensureNullableInt($data[4]));
        $entity->setSolarEnergy($this->ensureNullableInt($data[5]));
        $entity->setTotal($this->ensureNullableInt($data[6]));
        $entity->setStatTransferToNorway($this->ensureNullableInt($data[7]));
        $entity->setRenewableEnergyInTargetCalculation($this->ensureNullableInt($data[8]));
        $entity->setTotalEnergyUse($this->ensureNullableInt($data[9]));

        return $entity;
    }

    private function ensureInt(mixed $value): ?int
{
    if ($value === null || $value === '') {
        return null; // Returnera null för tomma eller saknade celler
    }
    
    if (is_numeric($value)) {
        return (int) $value;
    }
    
    echo "Invalid value detected: " . print_r($value, true) . "\n";
    throw new InvalidArgumentException("Value is not a valid integer: " . print_r($value, true));
}

private function ensureNullableInt(mixed $value): ?int
{
    if ($value === null) {
        return null;
    }
    if (is_numeric($value)) {
        return (int) $value;
    }
    throw new InvalidArgumentException("Value is not a valid nullable integer: " . print_r($value, true));
}

}
