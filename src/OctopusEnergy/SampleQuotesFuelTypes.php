<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;

/**
 * Class SampleQuotesFuelTypes
 * @package OctopusEnergy
 *
 * @property SampleQuote $electricitySingleRate
 * @property SampleQuote $electricityDualRate
 * @property SampleQuote $dualFuelSingleRate
 * @property SampleQuote $dualFuelDualRate
 */
class SampleQuotesFuelTypes extends APIObject
{
    protected $nestedMap = [
        'electricitySingleRate' => SampleQuote::class,
        'electricityDualRate' => SampleQuote::class,
        'dualFuelSingleRate' => SampleQuote::class,
        'dualFuelDualRate' => SampleQuote::class
    ];
}
