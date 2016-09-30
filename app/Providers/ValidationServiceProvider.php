<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use Validator;
use App\Services\OptionValidation;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extendImplicit('option', 'App\Services\OptionValidator@option');
        Validator::extendImplicit('choice', 'App\Services\OptionValidator@choice');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
