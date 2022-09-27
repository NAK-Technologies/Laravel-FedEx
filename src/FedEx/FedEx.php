<?php

namespace NakTech\Couriers\FedEx;

use App\FedEx\traits\Rates;
use Illuminate\Support\Facades\Http;

class FedEx
{
    use Rates;


    protected $token;
    protected $token_type;
    protected $scope;
    protected $expiry;
    protected $account;
    public $shipper;
    public $recipient;
    public $pickupType;
    public $packages = [];
    public $serviceType;
    public $date;


    public function __construct($testing = false)
    {
        if ($testing) {
            $this->url = 'https://apis-sandbox.fedex.com/';
        } else {
            $this->url = 'https://apis.fedex.com/oauth/token';
        }
        $this->account = config('couriers.services.fedex.account');
        $url = 'oauth/token';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->url . $url, ['form_params' => [
            'client_id' => config('couriers.services.fedex.api_key'),
            'client_secret' => config('couriers.services.fedex.secret_key'),
            'grant_type' => config('couriers.services.fedex.grant_type'),
        ], 'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]]);

        $responseBody = json_decode($response->getBody(), true);
        $this->token = $responseBody['access_token'];
        $this->token_type = $responseBody['token_type'];
        $this->scope = $responseBody['scope'];
        $this->expiry = $responseBody['expires_in'];
    }
}
