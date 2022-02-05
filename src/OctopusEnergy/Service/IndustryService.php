<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\GridSupplyPoints;

class IndustryService extends AbstractService
{
    /**
     * Gets the grid supply points, narrowed down to a postcode region if specified.
     *
     * @param string|null $postcode The postcode to narrow the search down to.
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
