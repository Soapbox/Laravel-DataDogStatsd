<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit\Facades;

use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Facades\DataDog;

class DataDogTest extends TestCase
{
    /**
     * @test
     */
    public function it_delegates_calls_to_the_underlying_dog_statsd_object()
    {
        DataDog::fake();

        DataDog::timing('timing-stat', 1);
        DataDog::gauge('gauge-stat', 1);
        DataDog::histogram('histogram-stat', 1);
        DataDog::distribution('distribution-stat', 1);
        DataDog::set('set-stat', 1);
        DataDog::increment('increment-stat');
        DataDog::decrement('decrement-stat');

        DataDog::assertTimingWasSent('timing-stat', 1);
        DataDog::assertGaugeWasSent('gauge-stat', 1);
        DataDog::assertHistogramWasSent('histogram-stat', 1);
        DataDog::assertDistributionWasSent('distribution-stat', 1);
        DataDog::assertSetWasSent('set-stat', 1);
        DataDog::assertStatWasIncremented('increment-stat');
        DataDog::assertStatWasDecremented('decrement-stat');
    }

    /**
     * @test
     */
    public function it_can_fluently_send_timing_information()
    {
        DataDog::fake();

        DataDog::stat('stat')->withTags('tags')->withSampleRate(0.5)->timing(10);

        DataDog::assertTimingWasSent('stat', 10)->withTags('tags')->withSampleRate(0.5);
    }

    /**
     * @test
     */
    public function it_can_fluently_send_gauge_information()
    {
        DataDog::fake();

        DataDog::stat('stat')->withTags('tags')->withSampleRate(0.5)->gauge(10);

        DataDog::assertGaugeWasSent('stat', 10)->withTags('tags')->withSampleRate(0.5);
    }

    /**
     * @test
     */
    public function it_can_fluently_send_histogram_information()
    {
        DataDog::fake();

        DataDog::stat('stat')->withTags('tags')->withSampleRate(0.5)->histogram(10);

        DataDog::assertHistogramWasSent('stat', 10)->withTags('tags')->withSampleRate(0.5);
    }

    /**
     * @test
     */
    public function it_can_fluently_send_distribution_information()
    {
        DataDog::fake();

        DataDog::stat('stat')->withTags('tags')->withSampleRate(0.5)->distribution(10);

        DataDog::assertDistributionWasSent('stat', 10)->withTags('tags')->withSampleRate(0.5);
    }

    /**
     * @test
     */
    public function it_can_fluently_send_set_information()
    {
        DataDog::fake();

        DataDog::stat('stat')->withTags('tags')->withSampleRate(0.5)->set(10);

        DataDog::assertSetWasSent('stat', 10)->withTags('tags')->withSampleRate(0.5);
    }

    /**
     * @test
     */
    public function it_can_fluently_increment_a_stat()
    {
        DataDog::fake();

        DataDog::stat('stat')->withTags('tags')->withSampleRate(0.5)->increment();

        DataDog::assertStatWasIncremented('stat')->withTags('tags')->withSampleRate(0.5);
    }
}
