<?php

namespace JSHayes\LaravelDataDogStatsd;

use DataDog\DogStatsd;
use DataDog\BatchedDogStatsd;
use Illuminate\Contracts\Foundation\Application;

class DataDog
{
    /**
     * The DogStatsd instance
     *
     * @var \DataDog\DogStatsd
     */
    protected $instance;

    /**
     * Create a new DataDog wrapper
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Create a StatBuilder for the given stat to fluently send stats
     *
     * @param string $stat
     *
     * @return \JSHayes\LaravelDataDogStatsd\StatBuilder
     */
    public function stat(string $stat): StatBuilder
    {
        return new StatBuilder($this->getStatsdInstance(), $stat);
    }

    /**
     * Delegate calls to the DogStatsd instance
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters = [])
    {
        return call_user_func_array([$this->getStatsdInstance(), $method], $parameters);
    }

    /**
     * Create the single DogStatsd driver
     *
     * @param array $config
     *
     * @return \DataDog\DogStatsd
     */
    private function createSingleDriver(array $config): DogStatsd
    {
        return new DogStatsd($config);
    }

    /**
     * Create the BatchedDogStatsd driver
     *
     * @param array $config
     *
     * @return \DataDog\BatchedDogStatsd
     */
    private function createBatchedDriver(array $config): BatchedDogStatsd
    {
        $statsd = new BatchedDogStatsd($config);
        $this->app->terminating(function () use ($statsd) {
            $statsd->flush_buffer();
        });
        return $statsd;
    }

    /**
     * Make the statsd driver based on the configuration
     *
     * @return \DataDog\DogStatsd
     */
    private function makeStatsdInstance(): DogStatsd
    {
        $driver = $this->app['config']['datadog.driver'];
        $method = "create{$driver}Driver";
        return $this->$method($this->app['config']["datadog.drivers.$driver"]);
    }

    /**
     * Get the statsd driver
     *
     * @return \DataDog\DogStatsd
     */
    protected function getStatsdInstance(): DogStatsd
    {
        return $this->instance = $this->instance ?? $this->makeStatsdInstance();
    }
}
