<?php

namespace JSHayes\LaravelDataDogStatsd\Facades;

use Illuminate\Support\Facades\Facade;
use JSHayes\LaravelDataDogStatsd\Testing\DataDogFake;

class DataDog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'datadog';
    }

    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new DataDogFake(static::getFacadeApplication()));
    }
}
