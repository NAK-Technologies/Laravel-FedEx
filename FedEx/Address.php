<?php

namespace App\FedEx;


class Address
{
    public $city;
    public $zip;
    public $countryCode;
    public $streetLines;

    public function __construct($street = [], $city = '', $country = '', $zip = '')
    {
        if(empty($street) || empty($city) || empty($country) || empty($zip)){
            $street = [env('ADDRESS_LINE_2'), env('ADDRESS_LINE_1')];
            $city = env('CITY');
            $country = env('COUNTRY');
            $zip = env('ZIP');
        }
        $this->streetLines = $street;
        $this->zip = $zip;
        $this->countryCode = $country;
        $this->city = $city;
    }
}
