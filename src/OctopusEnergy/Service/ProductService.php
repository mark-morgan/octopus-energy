<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\Product;
use OctopusEnergy\ProductSearch;

class ProductService extends AbstractService
{
    /**
     * Gets all Products as a ProductSearch object.
     *
     * @return ProductSearch
     */
    public function all(): ProductSearch
    {
        return $this->request(
            'get',
            '/v1/products/',
            [],
            [
                'type' => ProductSearch::class
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
