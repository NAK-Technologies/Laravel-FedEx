<?php

namespace App\FedEx\traits;

use App\FedEx\FedEx;
use Illuminate\Support\Facades\Cache;
use Throwable;

trait Rates
{
    public function getRates()
    {
        $url = 'rate/v1/rates/quotes';

        $packages = [];
        if(!Cache::store(env('CACHE_DRIVER'))->has('FedEx')){
            // dd('hello');
            $res = FedEx::authenticate(true);
            FedEx::initProperties($res);
        }
        // dd($this->recipient->streetLines);
        foreach($this->packages as $package){
            // dd($package);
            $packages[] = [
                            'weight' => [
                                'units' => $package->weightUnits,
                                'value' => $package->weight
                            ],
                            'dimensions' => [
                                'units' => $package->dimensionsUnits,
                                'height' => $package->height,
                                'width' => $package->width,
                                'length' => $package->length,
                            ]
                        ];
        }

        // dd($this->shipper->city);
        // dd($packages);
        $params = [
            'accountNumber' => [
                'value' => $this->account
            ],
            'requestedShipment' => [
                'shipper' => [
                    'address' => [
                        'streetLines' => $this->shipper->streetLines,
                        'city' => $this->shipper->city,
                        'postalCode' => $this->shipper->zip,
                        'countryCode' => $this->shipper->countryCode
                    ]
                ],
                'recipient' => [
                    'address' => [
                        'streetLines' => $this->recipient->streetLines,
                        'city' => $this->recipient->city,
                        'postalCode' => $this->recipient->zip,
                        'countryCode' => $this->recipient->countryCode
                    ]
                ],
                'serviceType' => $this->serviceType->service ?? '',
                'preferredCurrency' => 'USD',
                'rateRequestType' => ['PREFERRED'],
                'shipDateStamp' => \Carbon\Carbon::parse($this->pickup->date == '' ? \Carbon\Carbon::now() : $this->pickup->date)->format('Y-m-d'),
                'pickupType' => $this->pickup->pickupType,
                'requestedPackageLineItems' => $packages,
                "edtRequestType" => "ALL"
            ]
        ];

        // dd(json_encode($params));
        try{
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', self::$url.$url, ['json' => $params, 'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.self::$token,
            ]]);
            $res = collect(json_decode($response->getBody()->getContents(),true))['output']['rateReplyDetails'];
        }catch (Throwable $e){
            return 'error';
        }

        // $res = array_map(function ($el) {
        //     $charges = array_map(function ($e){
        //         return ['rate_type' => $e->rateType, 'charges' => $e->totalNetFedExCharge];
        //     }, $el->ratedShipmentDetails);
        //     return ['serviceName' => $el->serviceName, 'charges' => $charges];
        // }, $res);
        // // dd(collect(json_decode($response->getBody()->getContents()))['output']->rateReplyDetails);
        // dd($res);
        // return $res;
        return $res;
    }
}
