<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $contracts = config("api.contracts");
        $bindings = config('api.bindings');
        foreach($contracts as $contract)
        {
            $this->app->bind($contract, function($app) use ($contract, $bindings)
            {
                $version = Request::segment(2);
                return $app[$bindings[$version][$contract]];
            });
        }
    }
}
