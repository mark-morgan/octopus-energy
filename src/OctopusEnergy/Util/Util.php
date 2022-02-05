<?php

namespace OctopusEnergy\Util;

use OctopusEnergy\API\APIObject;

class Util
{
    /**
     * Converts from am APIObject class to an associative array ready for sending back to the Octopus Energy API.
     *
     * @param APIObject $obj
     * @param bool $recursive
     *
     * @return array
     */
    public static function convertFromClass(APIObject $obj, bool $recursive = true): array
    {
        $kv = $obj->keyValues();

        foreach ($kv as $key => $value) {

            if ($value instanceof \DateTime) {
                $strVal = $value->format('Y-m-d');

                // TODO: check the format going back to OE
                $strVal .= 'T' . $value->format('H:i:s.u') . 'Z';

                $kv[$key] = $strVal;
            }
            elseif ($value instanceof APIObject && true === $recursive) {
                $kv[$key] = self::convertFromClass($value, true);
            }
            elseif (is_array($value)) {
                // this could be an array of APIObjects, process them one by one
                foreach ($value as $arrKey => $arrValue) {
                    if ($arrValue instanceof APIObject && true === $recursive) {
                        $value[$arrKey] = self::convertFromClass($arrValue, true);
                    }
                }

                $kv[$key] = $value;
            }
        }

        return $kv;
    }

    /**
     * Converts an Octopus Energy API JSON response body to corresponding APIObjects.
     *
     * @param $apiResponseBodyJSON
     * @param $opts
     * @param bool $validateOpts
     *
     * @return array|APIObject
     */
    public static function convertToClass($apiResponseBodyJSON, $opts, bool $validateOpts = true)
    {
        if (static::isList($apiResponseBodyJSON)) {
            return static::convertToClasses($apiResponseBodyJSON, $opts);
        }

        if ($validateOpts) {
            static::validateOpts($opts);
        }

        $type = $opts['type'];
        unset($opts['type']);

//        $client = array_key_exists('client', $opts) ? $opts['client'] : null;

        /** @var APIObject $obj */
        $obj = new $type($opts);

        $obj->populateFromValues($apiResponseBodyJSON);

        return $obj;
    }

    /**
     * Converts an OctopusEnergy API JSON response body to an array of APIObjects.
     *
     * @param $apiResponseBodyJSON
     * @param $opts
     *
     * @return array
     */
    public static function convertToClasses($apiResponseBodyJSON, $opts): array
    {
        static::validateOpts($opts);

        $classes = [];
        foreach ($apiResponseBodyJSON as $item) {
            $classes[] = static::convertToClass($item, $opts, false);
        }

        return $classes;
    }

    /**
     * Generates a pseudo-unique UUID formatted string.
     *
     * @return string The pseudo-unique string
     */
    public static function generateUUID(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Checks if an object is a list.
     *
     * @param $var
     *
     * @return bool
     */
    public static function isList($var): bool
    {
        if (!is_array($var)) {
            return false;
        }

        if ([] === $var) {
            // empty array
            return true;
        }

        if (array_keys($var) !== range(0, count($var) - 1)) {
            return false;
        }

        return true;
    }

    /**
     * Validates that a minimum set of opts has been set.
     *
     * @param array $opts
     */
    protected static function validateOpts(array $opts)
    {
        if (null === $opts['type']) {
            throw new \OctopusEnergy\Exception\InvalidArgumentException('type must be set');
        }
    }
}
