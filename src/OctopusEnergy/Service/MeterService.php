<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\Consumption;
use OctopusEnergy\ElectricityMeter;
use OctopusEnergy\Exception\InvalidArgumentException;
use OctopusEnergy\Search;
use OctopusEnergy\Util\Util;

class MeterService extends AbstractService
{
    /**
     * Gets the electricity meter with given MPAN number.
     *
     * @param string $mpan Meter MPAN number.
     *
     * @return ElectricityMeter
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

    /**
     * Gets the consumption for an electricity meter.
     *
     * @param string $mpan Meter MPAN number.
     * @param string $serialNumber Meter serial number.
     * @param int $page The page of the results. When using a page > 1, ensure that you have checked the result count from page 1
     * to not request a page that would take you past the last result.
     * @param \DateTime|null $periodFrom The lower end of the search range, inclusive.
     * @param \DateTime|null $periodTo The upper end of the search range, exclusive.
     * @param int $pageSize Defaults to 100, max 25000.
     *
     * @return Search
     *
     * @throws InvalidArgumentException
     */
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
            throw new InvalidArgumentException('pageSize cannot be greater than 25,000');
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
