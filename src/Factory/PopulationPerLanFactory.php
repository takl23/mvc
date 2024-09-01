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
     * @return PopulationPerLan
     * @throws InvalidArgumentException
     */
    public function create(array $data): PopulationPerLan
    {
        // Kontrollera att inget värde är null eller saknas
        foreach ($data as $value) {
            if ($value === null || $value === '') {
                throw new InvalidArgumentException("All values must be non-null and non-empty.");
            }
        }

        $entity = new PopulationPerLan();
        $entity->setYear($this->ensureInt($data[0]));
        $entity->setStockholm($this->ensureInt(str_replace(' ', '', $data[1])));
        $entity->setUppsala($this->ensureInt(str_replace(' ', '', $data[2])));
        $entity->setSodermanland($this->ensureInt(str_replace(' ', '', $data[3])));
        $entity->setOstergotland($this->ensureInt(str_replace(' ', '', $data[4])));
        $entity->setJonkoping($this->ensureInt(str_replace(' ', '', $data[5])));
        $entity->setKronoberg($this->ensureInt(str_replace(' ', '', $data[6])));
        $entity->setKalmar($this->ensureInt(str_replace(' ', '', $data[7])));
        $entity->setGotland($this->ensureInt(str_replace(' ', '', $data[8])));
        $entity->setBlekinge($this->ensureInt(str_replace(' ', '', $data[9])));
        $entity->setSkane($this->ensureInt(str_replace(' ', '', $data[10])));
        $entity->setHalland($this->ensureInt(str_replace(' ', '', $data[11])));
        $entity->setVastraGotaland($this->ensureInt(str_replace(' ', '', $data[12])));
        $entity->setVarmland($this->ensureInt(str_replace(' ', '', $data[13])));
        $entity->setOrebro($this->ensureInt(str_replace(' ', '', $data[14])));
        $entity->setVastmanland($this->ensureInt(str_replace(' ', '', $data[15])));
        $entity->setVasternorrland($this->ensureInt(str_replace(' ', '', $data[16])));
        $entity->setJamtland($this->ensureInt(str_replace(' ', '', $data[17])));
        $entity->setVasterbotten($this->ensureInt(str_replace(' ', '', $data[18])));
        $entity->setNorrbotten($this->ensureInt(str_replace(' ', '', $data[19])));

        return $entity;
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
