<?php

namespace JSHayes\LaravelDataDogStatsd\Testing;

use JSHayes\LaravelDataDogStatsd\DataDog;
use Illuminate\Contracts\Foundation\Application;

class DataDogFake extends DataDog
{
    /**
     * Create a new DataDogFake object
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->instance = new StatsdFake();
    }

    /**
     * Make the StatsAssertion helper for the given stat
     *
     * @param string $stat
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    private function makeAssertion(string $stat): StatsAssertion
    {
        return new StatsAssertion($this->getStatsdInstance()->getStats(), $stat);
    }

    /**
     * Assert that the given stat was not sent
     *
     * @param string $stat
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertStatWasNotSent(string $stat): StatsAssertion
    {
        return $this->makeAssertion($stat)->times(0);
    }

    /**
     * Assert that the given stat had timing information sent
     *
     * @param string $stat
     * @param float $time
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertTimingWasSent(string $stat, float $time): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$time|ms");
    }

    /**
     * Assert that the given stat had gauge information sent
     *
     * @param string $stat
     * @param float $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertGaugeWasSent(string $stat, float $value): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|g");
    }

    /**
     * Assert that the given stat had histogram information sent
     *
     * @param string $stat
     * @param float $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertHistogramWasSent(string $stat, float $value): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|h");
    }

    /**
     * Assert that the given stat had distribution information sent
     *
     * @param string $stat
     * @param float $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertDistributionWasSent(string $stat, float $value): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|d");
    }

    /**
     * Assert that the given stat had set information sent
     *
     * @param string $stat
     * @param float $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertSetWasSent(string $stat, float $value): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|s");
    }

    /**
     * Assert that the given stat was incremented by the given value
     *
     * @param string $stat
     * @param int $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertStatWasIncremented(string $stat, int $value = 1): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|c");
    }

    /**
     * Assert that the given stat was decremented by the given value
     *
     * @param string $stat
     * @param int $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertStatWasDecremented(string $stat, int $value = -1): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|c");
    }

    /**
     * Assert that the given stat was updated by the given value
     *
     * @param string $stat
     * @param int $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion
     */
    public function assertStatWasUpdated(string $stat, int $value): StatsAssertion
    {
        return $this->makeAssertion($stat)->withValue("$value|c");
    }
}
