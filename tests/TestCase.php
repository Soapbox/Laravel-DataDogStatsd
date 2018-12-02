<?php

namespace JSHayes\LaravelDataDogStatsd\Tests;

use JSHayes\LaravelDataDogStatsd\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set([
            'datadog' => [
                'driver' => 'batched',
                'drivers' => [
                    'batched' => [],
                ],
            ],
        ]);
    }
}
