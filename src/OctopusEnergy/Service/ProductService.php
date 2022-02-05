<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\Product;
use OctopusEnergy\Search;

class ProductService extends AbstractService
{
    /**
     * Gets all Products as a ProductSearch object.
     *
     * @return Search
     */
    public function all(): Search
    {
        return $this->request(
            'get',
            '/v1/products/',
            [],
            [
                'type' => Search::class,
                'nestedMap' => [
                    'results' => Product::class
                ]
            ]
        );
    }

    /**
     * @param string $productCode
     *
     * @return Product
     */
    public function get(string $productCode): Product
    {
        return $this->request(
            'get',
            '/v1/products/' . $productCode . '/',
            [],
            [
                'type' => Product::class
            ]
        );
    }
}
