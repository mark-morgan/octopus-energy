<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\Consumption;
use OctopusEnergy\ElectricityMeter;
use OctopusEnergy\GridSupplyPoints;
use OctopusEnergy\Search;

class MeterService extends AbstractService
{
    /**
     * @param string|null $postcode
     *
     * @return GridSupplyPoints
     */
    public function getElectricityMeter(string $mpan): ElectricityMeter
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

    public function getElectricityMeterConsumption(string $mpan, string $serialNumber)
    {
        $val = $this->request(
            'get',
            '/v1/electricity-meter-points/' . $mpan . '/meters/' . $serialNumber . '/consumption/',
            [],
            [
                'type' => Search::class,
                'nestedMap' => [
                    'results' => Consumption::class
                ]
            ]
        );

        $done = true;
        return $val;
    }
}
