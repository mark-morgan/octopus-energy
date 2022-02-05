<?php

namespace OctopusEnergy\Format;

class FloatToStringFormatter implements FormatInterface
{
    /**
     * Formats a float from the Octopus Energy API to a string
     *
     * @param $originalValue
     *
     * @return string|null
     */
    public function format($originalValue): ?string
    {
        if ($originalValue === null) {
            return null;
        }

        return (string)$originalValue;
    }
}