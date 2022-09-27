<?php

namespace NakTech\Couriers\FedEx;


class Service
{
    public $services = [
        'FEDEX_GROUND',
        'FEDEX_EXPRESS_SAVER',
        'FIRST_OVERNIGHT',
        'INTERNATIONAL_ECONOMY',
        'PRIORITY_OVERNIGHT',
        'STANDARD_OVERNIGHT',
    ];

    public $service;

    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }
}
