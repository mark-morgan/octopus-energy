<?php

namespace OctopusEnergy;

use OctopusEnergy\Format\DateTimeFormatter;
use OctopusEnergy\API\APIObject;

/**
 * Class Product
 * @package OctopusEnergy
 *
 * @property string $code
 * @property string $direction
 * @property string $fullName
 * @property string $displayName
 * @property string $description
 * @property bool $isVariable
 */
class Product extends APIObject
{
    protected $formatMap = [
        'availableFrom' => DateTimeFormatter::class,
        'availableTo' => DateTimeFormatter::class
    ];
}
