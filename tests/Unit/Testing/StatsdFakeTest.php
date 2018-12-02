<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit\Testing;

use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Testing\StatsdFake;

class StatsdFakeTest extends TestCase
{
    /**
     * @test
     */
    public function it_correctly_builds_the_stats_collection()
    {
        $statsd = new StatsdFake();

        $statsd->timing('timing-stat', 1);
        $statsd->gauge('gauge-stat', 1);
        $statsd->histogram('histogram-stat', 1);
        $statsd->distribution('distribution-stat', 1);
        $statsd->set('set-stat', 1);
        $statsd->increment('increment-stat');
        $statsd->decrement('decrement-stat');

        $this->assertEquals([
            ['stat' => 'timing-stat', 'value' => '1|ms', 'tags' => null, 'sample-rate' => 1],
            ['stat' => 'gauge-stat', 'value' => '1|g', 'tags' => null, 'sample-rate' => 1],
            ['stat' => 'histogram-stat', 'value' => '1|h', 'tags' => null, 'sample-rate' => 1],
            ['stat' => 'distribution-stat', 'value' => '1|d', 'tags' => null, 'sample-rate' => 1],
            ['stat' => 'set-stat', 'value' => '1|s', 'tags' => null, 'sample-rate' => 1],
            ['stat' => 'increment-stat', 'value' => '1|c', 'tags' => null, 'sample-rate' => 1],
            ['stat' => 'decrement-stat', 'value' => '-1|c', 'tags' => null, 'sample-rate' => 1],
        ], $statsd->getStats()->toArray());
    }
}
