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
        $entity = new RenewableEnergyTWh();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setBiofuels($this->ensureInt($data[1]));
        $entity->setHydropower($this->ensureInt($data[2]));
        $entity->setWindPower($this->ensureInt($data[3]));
        $entity->setHeatPump($this->ensureInt($data[4]));
        $entity->setSolarEnergy($this->ensureInt($data[5]));
        $entity->setTotal($this->ensureInt($data[6]));
        $entity->setStatTransferToNorway($this->ensureInt($data[7]));
        $entity->setRenewableEnergyInTargetCalculation($this->ensureInt($data[8]));
        $entity->setTotalEnergyUse($this->ensureInt($data[9]));

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
