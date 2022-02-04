<?php

namespace OctopusEnergy\API;

/**
 * Class Response.
 *
 * @package OctopusEnergy\API
 */
class Response
{
    /**
     * @var null|array
     */
    public $headers;

    /**
     * @var string
     */
    public $body;

    /**
     * @var null|array
     */
    public $json;

    /**
     * @var int
     */
    public $code;

    /**
     * @param string $body
     * @param int $code
     * @param null|array $headers
     * @param null|array $json
     */
    public function __construct($body, $code, $headers, $json = null)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
        $this->json = $json;
    }
}
