<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\ElectricityMeter;
use OctopusEnergy\GridSupplyPoints;

class MeterService extends AbstractService
{
    /**
     * @param string|null $postcode
     *
     * @return GridSupplyPoints
     */
    public function getElectricityMeter(string $mpan): GridSupplyPoints
    {
        return $this->request(
            'get',
            '/v1/electricity-meter-points/' . $mpan . '/',
            [],
            [
                'type' => ElectricityMeter::class
            ]
        );
    }
}
