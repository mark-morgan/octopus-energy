<?php

namespace OctopusEnergy\Service;

class Factory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'products' => ProductService::class
    ];

    /** @var \OctopusEnergy\Client */
    private $client;

    /** @var array<string, AbstractService> */
    private $services;

    /**
     * @param \OctopusEnergy\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @param string $name
     *
     * @return null|AbstractService
     */
    public function __get($name): ?AbstractService
    {
        $serviceClass = $this->getServiceClass($name);

        if (null !== $serviceClass) {

            if (!\array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }

    protected function getServiceClass($name): ?string
    {
        return array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
