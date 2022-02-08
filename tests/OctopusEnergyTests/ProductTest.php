<?php

namespace OctopusEnergyTests;

use OctopusEnergy\Exception\APIClientException;
use OctopusEnergy\Product;

class ProductTest extends BaseTest
{
    public function testGetAllProducts()
    {
        $productSearch = static::$client->products->all();

        $this->assertGreaterThan(0, $productSearch->count);

        foreach ($productSearch->results as $result) {
            $this->assertInstanceOf(Product::class, $result);
        }
    }

    public function testGetSpecificProduct()
    {
        $productCode = 'VAR-21-09-29';

        $product = static::$client->products->get($productCode);

        $this->assertEquals('Flexible Octopus October 2021 v2', $product->fullName);
        $this->assertEquals('OCTOPUS_ENERGY', $product->brand);
        $this->assertEquals(true, $product->isVariable);
        $this->assertEquals(false, $product->isGreen);
        $this->assertEquals(false, $product->isTracker);
        $this->assertEquals(false, $product->isPrepay);
        $this->assertEquals(false, $product->isBusiness);
        $this->assertEquals(false, $product->isRestricted);
    }

    public function testGetSpecificIncorrectProduct()
    {
        $this->expectException(APIClientException::class);
        $productCode = 'VAR-29-09-29';

        $product = static::$client->products->get($productCode);
    }
}