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
        $entity->setStockholm($this->ensureInt($this->sanitizeString($data[1])));
        $entity->setUppsala($this->ensureInt($this->sanitizeString($data[2])));
        $entity->setSodermanland($this->ensureInt($this->sanitizeString($data[3])));
        $entity->setOstergotland($this->ensureInt($this->sanitizeString($data[4])));
        $entity->setJonkoping($this->ensureInt($this->sanitizeString($data[5])));
        $entity->setKronoberg($this->ensureInt($this->sanitizeString($data[6])));
        $entity->setKalmar($this->ensureInt($this->sanitizeString($data[7])));
        $entity->setGotland($this->ensureInt($this->sanitizeString($data[8])));
        $entity->setBlekinge($this->ensureInt($this->sanitizeString($data[9])));
        $entity->setSkane($this->ensureInt($this->sanitizeString($data[10])));
        $entity->setHalland($this->ensureInt($this->sanitizeString($data[11])));
        $entity->setVastraGotaland($this->ensureInt($this->sanitizeString($data[12])));
        $entity->setVarmland($this->ensureInt($this->sanitizeString($data[13])));
        $entity->setOrebro($this->ensureInt($this->sanitizeString($data[14])));
        $entity->setVastmanland($this->ensureInt($this->sanitizeString($data[15])));
        $entity->setVasternorrland($this->ensureInt($this->sanitizeString($data[16])));
        $entity->setJamtland($this->ensureInt($this->sanitizeString($data[17])));
        $entity->setVasterbotten($this->ensureInt($this->sanitizeString($data[18])));
        $entity->setNorrbotten($this->ensureInt($this->sanitizeString($data[19])));

        return $entity;
    }

    private function sanitizeString(mixed $value): string
    {
        if (is_string($value)) {
            return str_replace(' ', '', $value);
        }

        if (is_numeric($value)) {
            return str_replace(' ', '', (string)$value);
        }

        throw new InvalidArgumentException("Value cannot be converted to string: " . print_r($value, true));
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
