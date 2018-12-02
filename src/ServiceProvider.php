<?php

namespace JSHayes\LaravelDataDogStatsd;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('datadog', DataDog::class);
    }
}
