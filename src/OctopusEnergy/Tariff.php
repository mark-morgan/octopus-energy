<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;

/**
 * Class Tariff
 * @package OctopusEnergy
 *
 * @property string $code
 * @property float $standingChargeExcVat
 * @property float $standingChargeIncVat
 * @property int $onlineDiscountExcVat
 * @property int $onlineDiscountIncVat
 * @property int $dualFuelDiscountExcVat
 * @property int $dualFuelDiscountIncVat
 * @property int $exitFeesExcVat
 * @property int $exitFeesIncVat
 * @property float $standardUnitRateExcVat
 * @property float $standardUnitRateIncVat
 * @property array $links
 */
class Tariff extends APIObject
{
    protected $nestedMap = [
        'links' => Link::class
    ];
}
