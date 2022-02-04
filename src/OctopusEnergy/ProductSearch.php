<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;

/**
 * Class ProductSearch
 * @package OctopusEnergy
 *
 * @property int $count
 * @property ?string $next
 * @property ?string $previous
 * @property array $results
 */
class ProductSearch extends APIObject
{
    protected $nestedMap = [
        'results' => Product::class
    ];
}
