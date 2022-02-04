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
            // format the key in a more php friendly format
            $formattedKey = static::toLowerCamelCase($key);
            if (array_key_exists($formattedKey, $this->nestedMap)) {
                // this is a nested property, need a nested object to utilise this
                $this->values[$formattedKey] = \OctopusEnergy\Util\Util::convertToClass($value, ['type' => $this->nestedMap[$formattedKey]], false);
            } else {
                // just a normal property
                if (array_key_exists($formattedKey, $this->formatMap)) {
                    // formatting required
                    $this->values[$formattedKey] = $this::getFormatter($this->formatMap[$formattedKey])->format($value);
                } else {
                    // no formatting required
                    $this->values[$formattedKey] = $value;
                }
            }
        }
    }

    public function overrideValues(array $values): void
    {
        $this->values = $values;
    }

    protected static function toLowerCamelCase(string $str): string
    {
        return str_replace('_', '', lcfirst(ucwords($str, '_')));
    }

    protected static function fromLowerCamelCase(string $str): string
    {
        return strtolower(implode('_', preg_split('/(?=[A-Z])/', $str)));
    }

    protected static function getFormatter(string $formatterClass): FormatInterface
    {
        if (array_key_exists($formatterClass, static::$initialisedFormatters) !== true) {
            static::$initialisedFormatters[$formatterClass] = new $formatterClass();
        }

        return static::$initialisedFormatters[$formatterClass];
    }
}
