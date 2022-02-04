<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\ProductSearch;

class ProductService extends AbstractService
{
    /**
     * Gets all Products as a ProductSearch object.
     *
     * @return ProductSearch
     */
    public function all()
    {
        return $this->request(
            'get',
            '/v1/products/',
            [],
            [
                'type' => \OctopusEnergy\ProductSearch::class
            ]
        );
    }
}
