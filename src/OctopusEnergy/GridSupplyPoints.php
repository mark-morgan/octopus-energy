<?php

namespace OctopusEnergy;

use OctopusEnergy\Format\DateTimeFormatter;
use OctopusEnergy\API\APIObject;

/**
 * Class GridSupplyPoints
 * @package OctopusEnergy
 *
 * @property int $count
 * @property ?string $next
 * @property ?string $previous
 * @property array $results
 */
class GridSupplyPoints extends APIObject
{
    protected $formatMap = [
        'availableFrom' => DateTimeFormatter::class,
        'availableTo' => DateTimeFormatter::class
    ];

    protected $nestedMap = [
        'results' => GridSupplyPoint::class
    ];
}
