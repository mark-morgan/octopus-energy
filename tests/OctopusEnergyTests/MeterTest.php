<?php

namespace OctopusEnergyTests;

use OctopusEnergy\Consumption;

class MeterTest extends BaseTest
{
    public function testGetElectricityMeter()
    {
        $meter = static::$client->meters->getElectricityMeter(static::getTestMeterMPAN());

        $this->assertEquals(static::getTestMeterMPAN(), $meter->mpan);
    }

    public function testGetElectricityMeterConsumption()
    {
        $numberToFetch = 10;

        $consumptionSearch = static::$client->meters->getElectricityMeterConsumption(
            static::getTestMeterMPAN(),
            static::getTestMeterSerial(),
            1,
            null,
            null,
            $numberToFetch
        );

        $this->assertEquals($numberToFetch, count($consumptionSearch->results));

        foreach ($consumptionSearch->results as $result) {
            $this->assertInstanceOf(Consumption::class, $result);
            $this->assertIsString($result->consumption);
            $this->assertInstanceOf(\DateTime::class, $result->intervalStart);
        }
    }
}