<?php

namespace OctopusEnergy\API;

use OctopusEnergy\Exception\APIClientException;

class Requestor
{
    /**
     * @var null|string
     */
    private $authorization;

    /**
     * @var string
     */
    private $apiBase;

    /**
     * @var \GuzzleHttp\Client
     */
    private static $httpClient;

    /**
     * Creates a new instance of Requestor.
     *
     * @param string $authorization
     * @param string $apiBase
     */
    public function __construct(string $authorization, string $apiBase)
    {
        $this->authorization = $authorization;
        $this->apiBase = $apiBase;
    }

    public function request(string $method, string $url, array $params = [], array $opts = []): Response
    {
        list($rawBody, $rawCode, $rawHeaders) = $this->doRequest($method, $url, $params, $opts);

        $json = $this->processResponse($rawBody, $rawCode, $rawHeaders);
        return new Response($rawBody, $rawCode, $rawHeaders, $json);
    }

    private function doRequest(string $method, string $url, array $params, array $opts): array
    {
        try {
            $options = ['headers' => ['Authorization' => $this->authorization]];
            if ('get' !== $method && null !== $opts['paramsAsJSONBody'] && $opts['paramsAsJSONBody'] === true) {
                $options['headers']['Content-Type'] = 'application/json';
                $options['body'] = json_encode($params);
            } elseif (count($params) > 0) {
                $options['query'] = $params;
            }

            $response = $this->httpClient()->request($method, $this->apiBase . $url, $options);

            $rawBody = $response->getBody();
            $rawCode = $response->getStatusCode();
            $rawHeaders = $response->getHeaders();

            return [$rawBody, $rawCode, $rawHeaders];

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = $e->getMessage();
            $bodyContents = $e->getResponse()->getBody()->getContents();
            $errorJson = json_decode($bodyContents, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($errorJson['message'])) {
                $message = $errorJson['message'];
            }
            throw new APIClientException($message, $e->getRequest(), $e->getResponse(), $e, $e->getHandlerContext());

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            $message = $e->getMessage();
            $bodyContents = $e->getResponse()->getBody()->getContents();
            $errorJson = json_decode($bodyContents, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($errorJson['message'])) {
                $message = $errorJson['message'];
            }
            return [];
        }
    }

    /**
     * Processes a response and returns a json decoded body.
     *
     * @param $rawBody
     * @param $rawCode
     * @param $rawHeaders
     *
     * @return array|null The decoded json, null if the body wasnt able to be decoded
     *
     * @throws \Exception
     */
    private function processResponse($rawBody, $rawCode, $rawHeaders): ?array
    {
        $decoded = json_decode($rawBody, true);
        $jsonError = json_last_error();
        if (null === $decoded && JSON_ERROR_NONE !== $jsonError) {

            if (JSON_ERROR_SYNTAX === $jsonError) {
                // not a json body, just keep the raw body
                return null;
            }
            throw new \OctopusEnergy\Exception\UnexpectedValueException("Invalid response body from API: {$rawBody}  (HTTP response code was {$rawCode}, json_last_error() was {$jsonError})", $rawCode);
        }

        if ($rawCode < 200 || $rawCode >= 300) {
            // TODO: handle specific API errors here
            throw new \Exception('API error');
        }

        return $decoded;
    }

    private function httpClient(): \GuzzleHttp\Client
    {
        if (null === static::$httpClient) {
            static::$httpClient = new \GuzzleHttp\Client();
        }

        return static::$httpClient;
    }
}
