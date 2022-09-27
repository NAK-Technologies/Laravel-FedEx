<?php

namespace NakTech\Couriers;

use Illuminate\Support\ServiceProvider;
use NakTech\Couriers\FedEx\FedEx;

class CourierServiceProvider extends ServiceProvider
{
     public function boot()
     {
          $this->publishes([
               __DIR__ . '/FedEx/config/couriers.php' => config_path('couriers.php'),
          ]);
     }

     public function register()
     {
          $this->app->singleton(FedEx::class, function () {
               return new FedEx(true);
          });
     }
}
