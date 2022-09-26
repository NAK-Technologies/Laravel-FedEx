<?php


namespace App\FedEx;


class Pickup
{
    public $pickups = [
        'CONTACT_FEDEX_TO_SCHEDULE',
        'DROPOFF_AT_FEDEX_LOCATION'
    ];
    public $pickup;

    public function setPickup($pickup)
    {
        $this->pickup = $pickup;

        return $this;
    }
}
