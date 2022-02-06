<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;

/**
 * Class TariffsPaymentMethods
 * @package OctopusEnergy
 */
class TariffsPaymentMethods extends APIObject
{
    public function getPaymentMethods(): array
    {
        return $this->values; // this is a list of electricity tariffs, it can only hold GSP items
    }

    protected function getNestedMapClass(string $key): string
    {
        return Tariff::class;
    }

    protected function isInNestedMap(string $key): bool
    {
        return true; // this is a list of electricity tariffs, all keys need to be decoded into structured classes
    }
}
