<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;
use OctopusEnergy\Format\DateTimeFormatter;

/**
 * Class Charge
 * @package OctopusEnergy
 *
 * @property float $valueExcVat
 * @property float $valueIncVat
 * @property \DateTime $validFrom
 * @property ?\DateTime $validTo
 */
class Charge extends APIObject
{
    protected $formatMap = [
        'validFrom' => DateTimeFormatter::class,
        'validTo' => DateTimeFormatter::class
    ];
}
