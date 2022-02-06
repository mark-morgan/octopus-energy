<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;

/**
 * Class SampleConsumptions
 * @package OctopusEnergy
 *
 * @property SampleConsumptionElectricitySingleRate $electricitySingleRate
 * @property SampleConsumptionElectricityDualRate $electricityDualRate
 * @property SampleConsumptionDualFuelSingleRate $dualFuelSingleRate
 * @property SampleConsumptionDualFuelDualRate $dualFuelDualRate
 */
class SampleConsumptions extends APIObject
{
    protected $nestedMap = [
        'electricitySingleRate' => SampleConsumptionElectricitySingleRate::class,
        'electricityDualRate' => SampleConsumptionElectricityDualRate::class,
        'dualFuelSingleRate' => SampleConsumptionDualFuelSingleRate::class,
        'dualFuelDualRate' => SampleConsumptionDualFuelDualRate::class
    ];
}
