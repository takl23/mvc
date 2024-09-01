<?php

namespace App\Factory;

use App\Entity\PopulationPerLan;
use InvalidArgumentException;

class PopulationPerLanFactory
{
    /**
     * Create a PopulationPerLan entity from an array of data.
     *
     * @param array<int, mixed> $data The data used to create the entity.
     * @return PopulationPerLan|null
     */
    public function create(array $data): ?PopulationPerLan
    {
        if ($data[0] === null) {
            echo "Skipping row due to missing year in PopulationPerLan.\n";
            return null;
        }

        $entity = new PopulationPerLan();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setStockholm($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[1]))));
        $entity->setUppsala($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[2]))));
        $entity->setSodermanland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[3]))));
        $entity->setOstergotland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[4]))));
        $entity->setJonkoping($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[5]))));
        $entity->setKronoberg($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[6]))));
        $entity->setKalmar($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[7]))));
        $entity->setGotland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[8]))));
        $entity->setBlekinge($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[9]))));
        $entity->setSkane($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[10]))));
        $entity->setHalland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[11]))));
        $entity->setVastraGotaland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[12]))));
        $entity->setVarmland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[13]))));
        $entity->setOrebro($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[14]))));
        $entity->setVastmanland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[15]))));
        $entity->setVasternorrland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[16]))));
        $entity->setJamtland($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[17]))));
        $entity->setVasterbotten($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[18]))));
        $entity->setNorrbotten($this->ensureNullableInt(str_replace(' ', '', $this->ensureString($data[19]))));

        return $entity;
    }

    /**
     * Ensure the value is a valid string.
     *
     * @param mixed $value
     * @return string
     * @throws InvalidArgumentException
     */
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


    /**
         * Ensure the value is a valid integer.
         *
         * @param mixed $value
         * @return int
         * @throws InvalidArgumentException
         */    private function ensureInt(mixed $value): int
    {
        if (isset($value) && is_numeric($value)) {
            return (int) $value;
        }
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
