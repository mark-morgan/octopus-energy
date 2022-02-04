<?php

namespace OctopusEnergy;

use OctopusEnergy\API\APIObject;
use OctopusEnergy\API\Requestor;
use OctopusEnergy\API\Response;
use OctopusEnergy\Exception\UnexpectedValueException;
use OctopusEnergy\Service\IndustryService;
use OctopusEnergy\Service\ProductService;
use OctopusEnergy\Util\Util;

/**
 * @property ProductService $products
 * @property IndustryService $industry
 */
class Client
{
    /** @var string default base URL for OctopusEnergy's API */
    const DEFAULT_API_BASE = 'https://api.octopus.energy';

    /**
     * Default config to allow for partial overrides.
     *
     * @var array
     */
    private const DEFAULT_CONFIG = [
        'api_key' => null,
        'api_base' => self::DEFAULT_API_BASE
    ];

    /** @var array<string, mixed> */
    private $config;

    /** @var \OctopusEnergy\Service\Factory */
    private $factory;

    public function __construct(array $config = [])
    {
        $config = array_merge(static::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $config['authorization'] = 'Basic ' . base64_encode($config['api_key'] . ':');

        $this->config = $config;
    }

    public function __get($name)
    {
        if (null === $this->factory) {
            $this->factory = new \OctopusEnergy\Service\Factory($this);
        }

        return $this->factory->__get($name);
    }

    /**
     * Gets the base URL for OctopusEnergy's API.
     *
     * @return string The base URL
     */
    public function getApiBase(): string
    {
        return $this->config['api_base'];
    }

    /**
     * Gets the Authorization key.
     *
     * @return string The Authorization key used to send requests
     */
    public function getAuthorization(): string
    {
        return $this->config['authorization'];
    }

    /**
     * Send a request to OctopusEnergy's API.
     *
     * @param string $method HTTP method
     * @param string $path Path of the request
     * @param array $params Parameters of the request
     * @param array $opts Special modifiers of the request
     *
     * @return APIObject The object returned by OctopusEnergy's API
     */
    public function request(string $method, string $path, array $params = [], array $opts = [])
    {
        $requestor = new Requestor($this->getAuthorization(), $this->getApiBase());
        $response = $requestor->request($method, $path, $params, $opts);

        $opts['client'] = $this;
        if (Util::isList($response->json)) {
            $obj = Util::convertToClasses($response->json, $opts);
        } else {
            $obj = Util::convertToClass($response->json, $opts);
        }

        return $obj;
    }

    /**
     * Sends a request for a collection of items to OctopusEnergy's API.
     *
     * @param string $method HTTP method
     * @param string $path Path of the request
     * @param array $params Parameters of the request
     * @param array $opts Special modifiers of the request
     *
     * @return array APIObject array
     */
    public function requestCollection(string $method, string $path, array $params = [], array $opts = []): array
    {
        $obj = $this->request($method, $path, $params, $opts);
        if (!is_array($obj)) {
            $received_class = get_class($obj);
            $msg = "Expected to receive `array` object from OctopusEnergy API. Instead received `{$received_class}`.";

            throw new UnexpectedValueException($msg);
        }

        return $obj;
    }

    public function requestRaw(string $method, string $path, array $params = [], array $opts = []): Response
    {
        $requestor = new Requestor($this->getAuthorization(), $this->getApiBase());
        return $requestor->request($method, $path, $params, $opts);
    }

    /**
     * Validates the config required for the client to work.
     *
     * @param array<string, mixed> $config
     *
     * @throws \OctopusEnergy\Exception\InvalidArgumentException
     */
    private function validateConfig(array $config): void
    {
        // api key
        if (null === $config['api_key']) {
            throw new \OctopusEnergy\Exception\InvalidArgumentException('api_key must be set');
        }

        // TODO: validate api key
    }
}
