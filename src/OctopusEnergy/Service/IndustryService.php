<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\GridSupplyPoints;

class IndustryService extends AbstractService
{
    /**
     * @param string|null $postcode
     *
     * @return GridSupplyPoints
     */
    public function getGridSupplyPoints(string $postcode = null): GridSupplyPoints
    {
        $params = null === $postcode ? [] : ['postcode' => $postcode];
        return $this->request(
            'get',
            '/v1/industry/grid-supply-points/',
            $params,
            [
                'type' => GridSupplyPoints::class
            ]
        );
    }
}
