<?php

namespace OctopusEnergy\Service;

use OctopusEnergy\API\Response;

abstract class AbstractService
{
    /**
     * @var \OctopusEnergy\Client
     */
    protected $client;

    /**
     * Initializes a new instance of the AbstractService class.
     *
     * @param \OctopusEnergy\Client $client
     */
    public function __construct(\OctopusEnergy\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Builds a path using a list of resource id's and urlencode.
     *
     * @param string $basePath
     * @param mixed ...$ids
     *
     * @return string
     */
    protected function buildPath(string $basePath, ...$ids): string
    {
        foreach ($ids as $id) {
            // check ids
            if (null === $id || '' === trim($id)) {
                throw new \OctopusEnergy\Exception\InvalidArgumentException('The resource ID cannot be null, empty or whitespace');
            }
        }

        return sprintf($basePath, ...array_map('urlencode', $ids));
    }

    /**
     * Builds a query part of a path from an associative array
     *
     * @param array $queryParams
     *
     * @return string
     */
    protected function buildQuery(array $queryParams): string
    {
        $queryStr = '?';
        foreach ($queryParams as $queryParam => $paramValue) {
            if ('?' !== $queryStr) {
                $queryStr .= '&';
            }

            $queryStr .= trim($queryParam) . '=' . urlencode($paramValue);
        }

        return $queryStr;
    }

    /**
     * Gets the client.
     *
     * @return \OctopusEnergy\Client
     */
    protected function getClient(): \OctopusEnergy\Client
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $opts)
    {
        return $this->getClient()->request($method, $path, $params, $opts);
    }

    protected function requestCollection($method, $path, $params, $opts)
    {
        return $this->getClient()->requestCollection($method, $path, $params, $opts);
    }

    protected function requestRaw($method, $path, $params, $opts): Response
    {
        return $this->getClient()->requestRaw($method, $path, $params, $opts);
    }
}