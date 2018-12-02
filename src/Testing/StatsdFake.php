<?php

namespace JSHayes\LaravelDataDogStatsd\Testing;

use DataDog\DogStatsd;

class StatsdFake extends DogStatsd
{
    /**
     * The stats that were stats
     *
     * @var \Tests\Doubles\DataDog\StatsCollection
     */
    private $stats;

    /**
     * Create a new StatsdFake object
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->stats = new StatsCollection();
        parent::__construct($config);
    }

    /**
     * Push the stats into the StatsCollection
     *
     * @param array $data
     * @param float $sampleRate
     * @param array|string $tags
     *
     * @return void
     **/
    public function send($data, $sampleRate = 1.0, $tags = null)
    {
        foreach ($data as $stat => $value) {
            $this->stats->add($stat, $value, $sampleRate, $tags);
        }
    }

    /**
     * Retrieve the collection of stats
     *
     * @return \Tests\Doubles\DataDog\StatsCollection
     */
    public function getStats(): StatsCollection
    {
        return $this->stats;
    }
}
