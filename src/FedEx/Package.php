<?php

namespace NakTech\Couriers\FedEx;


class Package
{
    public function __construct(float $weight, int $height, int $width, int $length, string $weightUnits = 'LB', string $dimensionsUnits = 'CM')
    {
        $this->weight = $weight;
        $this->weightUnits = $weightUnits;
        $this->dimensionsUnits = $dimensionsUnits;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }
}
