<?php


namespace App\FedEx;


class Pickup
{
    public $pickups = [
        'CONTACT_FEDEX_TO_SCHEDULE',
        'DROPOFF_AT_FEDEX_LOCATION'
    ];
    public $pickupType;
    public $date;

    public function setPickup($pickup, $date='')
    {
        $this->pickupType = $pickup;
        $this->date = $date;

        return $this;
    }
}
