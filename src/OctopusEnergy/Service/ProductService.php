<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\Product;
use OctopusEnergy\Search;
use OctopusEnergy\Util\Util;

class ProductService extends AbstractService
{
    /**
     * Gets all Products as a Search object.
     *
     * @param bool|null $isVariable Fetch variable products.
     * @param bool|null $isGreen Fetch green products.
     * @param bool|null $isTracker Fetch tracker products.
     * @param bool|null $isPrepay Fetch prepay products.
     * @param bool|null $isBusiness Fetch business products.
     * @param \DateTime|null $availableAt  Fetch products available at the specific DateTime.
     * @param int $page Page to fetch, defaults to 1.
     *
     * @return Search
     */
    public function all(bool $isVariable = null, bool $isGreen = null, bool $isTracker = null, bool $isPrepay = null, bool $isBusiness = null, \DateTime $availableAt = null, int $page = 1): Search
    {
        $params = ['page' => $page];
        if (null !== $isVariable) {
            $params['is_variable'] = $isVariable;
        }

        if (null !== $isGreen) {
            $params['is_green'] = $isGreen;
        }

        if (null !== $isTracker) {
            $params['is_tracker'] = $isTracker;
        }

        if (null !== $isPrepay) {
            $params['is_prepay'] = $isPrepay;
        }

        if (null !== $isBusiness) {
            $params['is_business'] = $isBusiness;
        }

        if (null !== $availableAt) {
            $params['available_at'] = Util::convertToAPIDateTime($availableAt);
        }

        return $this->request(
            'get',
            '/v1/products/',
            $params,
            [
                'type' => Search::class,
                'nestedMap' => [
                    'results' => Product::class
                ]
            ]
        );
    }

    /**
     * Gets a specific product.
     *
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
