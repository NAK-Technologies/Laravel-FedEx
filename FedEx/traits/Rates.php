<?php

namespace App\FedEx\traits;


trait Rates
{
    public function getRates()
    {
        $url = 'rate/v1/rates/quotes';

        $packages = [];
        // dd($this->recipient->streetLines);
        foreach($this->packages as $package){
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
                'serviceType' => $this->serviceType->service,
                'preferredCurrency' => 'USD',
                'rateRequestType' => ['PREFERRED'],
                'shipDateStamp' => \Carbon\Carbon::parse($this->date)->format('Y-m-d'),
                'pickupType' => $this->pickupType->pickup,
                'requestedPackageLineItems' => $packages,
                "edtRequestType" => "ALL"
            ]
        ];

        // dd(json_encode($params));
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->url.$url, ['json' => $params, 'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        ]]);
        $res = collect(json_decode($response->getBody()->getContents()))['output']->rateReplyDetails;

        // $res = array_map(function ($el) {
        //     $charges = array_map(function ($e){
        //         return ['rate_type' => $e->rateType, 'charges' => $e->totalNetFedExCharge];
        //     }, $el->ratedShipmentDetails);
        //     return ['serviceName' => $el->serviceName, 'charges' => $charges];
        // }, $res);
        // // dd(collect(json_decode($response->getBody()->getContents()))['output']->rateReplyDetails);
        // dd($res[0]->ratedShipmentDetails[0]->totalNetFedExCharge);
        // return $res;
        return $res[0]->ratedShipmentDetails[0]->totalNetFedExCharge;
    }
}
