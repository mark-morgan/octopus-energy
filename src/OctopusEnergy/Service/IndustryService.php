<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\GridSupplyPoint;
use OctopusEnergy\GridSupplyPoints;
use OctopusEnergy\Search;

class IndustryService extends AbstractService
{
    /**
     * Gets the grid supply points, narrowed down to a postcode region if specified.
     *
     * @param string|null $postcode The postcode to narrow the search down to.
     *
     * @return Search
     */
    public function getGridSupplyPoints(string $postcode = null): Search
    {
        $params = null === $postcode ? [] : ['postcode' => $postcode];
        return $this->request(
            'get',
            '/v1/industry/grid-supply-points/',
            $params,
            [
                'type' => Search::class,
                'nestedMap' => [
                    'results' => GridSupplyPoint::class
                ]
            ]
        );
    }
}
