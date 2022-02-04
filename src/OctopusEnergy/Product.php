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
 * @property bool $isGreen
 * @property bool $isTracker
 * @property bool $isPrepay
 * @property bool $isBusiness
 * @property bool $isRestricted
 * @property ?\DateTime $availableFrom
 * @property ?\DateTime $availableTo
 * @property array $links
 * @property string $brand
 */
class Product extends APIObject
{
    protected $formatMap = [
        'availableFrom' => DateTimeFormatter::class,
        'availableTo' => DateTimeFormatter::class
    ];

    protected $nestedMap = [
        'links' => Link::class
    ];
}
