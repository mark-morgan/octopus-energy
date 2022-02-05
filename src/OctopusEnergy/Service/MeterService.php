<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\Consumption;
use OctopusEnergy\ElectricityMeter;
use OctopusEnergy\Exception\InvalidArgumentException;
use OctopusEnergy\GridSupplyPoints;
use OctopusEnergy\Search;
use OctopusEnergy\Util\Util;

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

    public function getElectricityMeterConsumption(
        string $mpan,
        string $serialNumber,
        int $page = 1,
        \DateTime $periodFrom = null,
        \DateTime $periodTo = null,
        int $pageSize = 100
    ): Search
    {
        if ($pageSize > 25000) {
            throw new InvalidArgumentException('$pageSize cannot be greater than 25,000');
        }

        $params = [
            'page' => $page,
            'page_size' => $pageSize
        ];
        if (null !== $periodFrom) {
            $params['period_from'] = Util::convertToAPIDateTime($periodFrom);
        }

        if (null !== $periodTo) {
            if (null === $periodFrom) {
                throw new InvalidArgumentException('$periodTo requires $periodFrom to be set, however it is currently null');
            }
            if ($periodTo < $periodFrom) {
                throw new InvalidArgumentException('$periodTo must be greater than $periodFrom');
            }
            $params['period_to'] = Util::convertToAPIDateTime($periodTo);
        }

        return $this->request(
            'get',
            '/v1/electricity-meter-points/' . $mpan . '/meters/' . $serialNumber . '/consumption/',
            $params,
            [
                'type' => Search::class,
                'nestedMap' => [
                    'results' => Consumption::class
                ]
            ]
        );
    }
}
