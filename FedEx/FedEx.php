<?php

namespace App\FedEx;

use App\FedEx\traits\Rates;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FedEx
{
    use Rates;


    protected static $token;
    protected static $token_type;
    protected static $scope;
    protected static $expiry;
    protected $account;
    public $shipper;
    public $recipient;
    public $pickup;
    public $packages = [];
    public $serviceType;
    public $date;
    public static $url;


    public function __construct($testing = false)
    {
        $this->account = env('FEDEX_ACCOUNT');

        $response = self::authenticate($testing);

        $responseBody = json_decode($response->getBody(), true);

        if(!Cache::store(env('CACHE_DRIVER'))->has('FedEx')){
            $responseBody = json_decode(self::authenticate()->getBody(), true);
            Cache::store(env('CACHE_DRIVER'))->put('FedEx', $responseBody['access_token'], $responseBody['expires_in']);
        }

        $this->initProperties($responseBody, $testing);

    }

    public static function initProperties($responseBody)
    {
        self::$token = Cache::store(env('CACHE_DRIVER'))->get('FedEx');
        self::$token_type = $responseBody['token_type'];
        self::$scope = $responseBody['scope'];
        self::$expiry = $responseBody['expires_in'];
    }

    public static function initUrl($testing = false)
    {
        if($testing){
            self::$url = 'https://apis-sandbox.fedex.com/';
        }else{
            self::$url = 'https://apis.fedex.com/';
        }
    }

    public static function authenticate($testing = false)
    {
        if(!self::$url){
            self::initUrl($testing);
        }
        $url = 'oauth/token';
        $client = new \GuzzleHttp\Client();

        return $client->request('POST', self::$url.$url, ['form_params' => [
            'client_id' => env('FEDEX_API_KEY'),
            'client_secret' => env('FEDEX_SECRET_KEY'),
            'grant_type' => 'client_credentials',
        ], 'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]]);
    }
}
