<?php

namespace App\FedEx;

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
        if($testing){
            $this->url = 'https://apis-sandbox.fedex.com/';
        }else{
            $this->url = 'https://apis.fedex.com/oauth/token';
        }
        $this->account = env('FEDEX_ACCOUNT');
        $url = 'oauth/token';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->url.$url, ['form_params' => [
            'client_id' => env('FEDEX_API_KEY'),
            'client_secret' => env('FEDEX_SECRET_KEY'),
            'grant_type' => 'client_credentials',
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
