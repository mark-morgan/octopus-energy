<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;

/**
 * Class Tariffs
 * @package OctopusEnergy
 */
class Tariffs extends APIObject
{
    public function getGridSupplyPoints(): array
    {
        return $this->values; // this is a list of tariffs, it can only hold GSP items
    }

    protected function getNestedMapClass(string $key): string
    {
        return TariffsPaymentMethods::class;
    }

    protected function isInNestedMap(string $key): bool
    {
        return true; // this is a list of tariffs, all keys need to be decoded into structured classes
    }
}
