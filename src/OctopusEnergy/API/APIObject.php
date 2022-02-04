<?php

namespace OctopusEnergy\API;

use OctopusEnergy\Format\FormatInterface;

class APIObject
{
//    /** @var Client $client */
//    protected $client = null;

    /** @var array $values */
    protected $values;

    /** @var array $nestedMap */
    protected $nestedMap = [];

    /** @var array $formatMap */
    protected $formatMap = [];

    /** @var array $initialisedFormatters */
    protected static $initialisedFormatters = [];

//    public function __construct(Client $client = null)
    public function __construct()
    {
//        $this->client = $client;
    }

    public function __get($k)
    {
        // function should return a reference, using $nullval to return a reference to null
        $nullval = null;
        if (!empty($this->values) && array_key_exists($k, $this->values)) {
            return $this->values[$k];
        }

        $class = static::class;
        error_log("Octopus Energy SDK: Undefined property of {$class} instance: {$k}");
        return null;
    }

    public function __set($k, $v)
    {
        $this->values[$k] = $v;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function keys(): array
    {
        return array_keys($this->values);
    }

    public function keyValues(): array
    {
        return $this->values;
    }

    public function values(): array
    {
        return array_values($this->values);
    }

    public function populateFromValues(array $values)
    {
        foreach ($values as $key => $value) {

            if (array_key_exists($key, $this->nestedMap)) {
                // this is a nested property, need a nested object to utilise this
                $this->values[$key] = \OctopusEnergy\Util\Util::convertToClass($value, ['type' => $this->nestedMap[$key]], false);
            } else {
                // just a normal property
                if (array_key_exists($key, $this->formatMap)) {
                    // formatting required
                    $this->values[$key] = $this::getFormatter($this->formatMap[$key])->format($value);
                } else {
                    // no formatting required
                    $this->values[$key] = $value;
                }
            }
        }
    }

    public function overrideValues(array $values): void
    {
        $this->values = $values;
    }

    protected static function getFormatter(string $formatterClass): FormatInterface
    {
        if (array_key_exists($formatterClass, static::$initialisedFormatters) !== true) {
            static::$initialisedFormatters[$formatterClass] = new $formatterClass();
        }

        return static::$initialisedFormatters[$formatterClass];
    }
}
