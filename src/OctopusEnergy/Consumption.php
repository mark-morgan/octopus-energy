<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;
use OctopusEnergy\Format\DateTimeFormatter;
use OctopusEnergy\Format\FloatToStringFormatter;

/**
 * Class Consumption
 * @package OctopusEnergy
 *
 * @property string $consumption
 * @property \DateTime $intervalStart
 * @property \DateTime $intervalEnd
 */
class Consumption extends APIObject
{
    protected $formatMap = [
        'consumption' => FloatToStringFormatter::class,
        'intervalStart' => DateTimeFormatter::class,
        'intervalEnd' => DateTimeFormatter::class
    ];
}
