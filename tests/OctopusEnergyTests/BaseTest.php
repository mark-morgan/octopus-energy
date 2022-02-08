<?php

namespace OctopusEnergyTests;

use OctopusEnergy\Client;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    /**
     * @var Client
     */
    protected static $client = null;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (null === static::$client) {
            static::$client = new Client(static::getTestApiKey());
        }
    }

    protected static function getTestApiKey(): string
    {
        return static::getFromEnv('OCTOPUS_API_KEY');
    }

    protected static function getTestMeterMPAN(): string
    {
        return static::getFromEnv('OCTOPUS_METER_MPAN');
    }

    protected static function getTestMeterSerial(): string
    {
        return static::getFromEnv('OCTOPUS_METER_SERIAL');
    }

    private static function getFromEnv(string $key): string
    {
        $value = getenv($key);
        if (false === $value) {
            throw new \Exception('Env var for "' . $key . '" not set, did you remember to create a phpunit.xml file with environment variables in it?');
        }

        return $value;
    }
}
