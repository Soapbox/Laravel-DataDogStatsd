<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Doubles;

use DataDog\DogStatsd;
use JSHayes\LaravelDataDogStatsd\DataDog;

class DataDogDouble extends DataDog
{
    /**
     * Set the statsd driver
     *
     * @param \DataDog\DogStatsd $instance
     *
     * @return \DataDog\DogStatsd
     */
    public function setStatsdInstance(DogStatsd $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Get the statsd driver
     *
     * @return \DataDog\DogStatsd
     */
    public function getStatsdInstance(): DogStatsd
    {
        return parent::getStatsdInstance();
    }
}
