<?php

namespace OctopusEnergy\Format;

class DateTimeFormatter implements FormatInterface
{
    /**
     * Formats a date from the Octopus Energy API to a PHP DateTime
     *
     * @param $originalValue
     *
     * @return \DateTime|null
     */
    public function format($originalValue): ?\DateTime
    {
        if ($originalValue === null) {
            return null;
        }

        return new \DateTime($originalValue);
    }
}