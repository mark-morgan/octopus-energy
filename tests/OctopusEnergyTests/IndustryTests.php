<?php

namespace OctopusEnergyTests;

use OctopusEnergy\GridSupplyPoint;

class IndustryTests extends BaseTest
{

    public function testGetAllGridSupplyPoints()
    {
        $gsp = static::$client->industry->getGridSupplyPoints();

        $this->assertGreaterThan(0, $gsp->count);

        foreach ($gsp->results as $result) {
            $this->assertInstanceOf(GridSupplyPoint::class, $result);
        }
    }
}