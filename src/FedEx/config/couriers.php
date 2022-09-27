<?php

return [
     "services" => [

          "FedEx" => [
               "account" => env('FEDEX_ACCOUNT'),
               "api_key" => env('FEDEX_API_KEY'),
               "secret_key" => env('FEDEX_SECRET_KEY'),
               'grant_type' => env('FEDEX_SECRET_KEY', 'client_credentials'),

               "sandbox" => true,
          ],

     ]
];
