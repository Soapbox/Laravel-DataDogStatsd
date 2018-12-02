<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit;

use Mockery;
use DataDog\DogStatsd;
use DataDog\BatchedDogStatsd;
use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Tests\Doubles\DataDogDouble;

class DataDogTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_batched_statsd_instance_when_configured()
    {
        $this->app['config']->set([
            'datadog' => [
                'driver' => 'batched',
                'drivers' => [
                    'batched' => [],
                ],
            ],
        ]);

        $dataDog = new DataDogDouble($this->app);
        $dataDog->getStatsdInstance();
        $this->assertInstanceOf(BatchedDogStatsd::class, $dataDog->getStatsdInstance());
    }

    /**
     * @test
     */
    public function it_creates_a_single_statsd_instance_when_configured()
    {
        $this->app['config']->set([
            'datadog' => [
                'driver' => 'single',
                'drivers' => [
                    'single' => [],
                ],
            ],
        ]);

        $dataDog = new DataDogDouble($this->app);
        $dataDog->getStatsdInstance();
        $this->assertInstanceOf(DogStatsd::class, $dataDog->getStatsdInstance());
    }

    /**
     * @test
     */
    public function it_delegates_the_timing_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->timing('stat', 10, 0.5, 'tags');

        $spy->shouldHaveReceived('timing')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_microtiming_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->microtiming('stat', 10, 0.5, 'tags');

        $spy->shouldHaveReceived('microtiming')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_gauge_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->gauge('stat', 10, 0.5, 'tags');

        $spy->shouldHaveReceived('gauge')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_histogram_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->histogram('stat', 10, 0.5, 'tags');

        $spy->shouldHaveReceived('histogram')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_distribution_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->distribution('stat', 10, 0.5, 'tags');

        $spy->shouldHaveReceived('distribution')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_set_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->set('stat', 10, 0.5, 'tags');

        $spy->shouldHaveReceived('set')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_increment_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->increment('stat', 0.5, 'tags', 2);

        $spy->shouldHaveReceived('increment')->with('stat', 0.5, 'tags', 2);
    }

    /**
     * @test
     */
    public function it_delegates_the_decrement_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->decrement('stat', 0.5, 'tags', -2);

        $spy->shouldHaveReceived('decrement')->with('stat', 0.5, 'tags', -2);
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_timing_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->timing(10);

        $spy->shouldHaveReceived('timing')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_microtiming_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->microtiming(10);

        $spy->shouldHaveReceived('microtiming')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_gauge_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->gauge(10);

        $spy->shouldHaveReceived('gauge')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_histogram_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->histogram(10);

        $spy->shouldHaveReceived('histogram')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_distribution_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->distribution(10);

        $spy->shouldHaveReceived('distribution')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_set_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->set(10);

        $spy->shouldHaveReceived('set')->with('stat', 10, 0.5, 'tags');
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_increment_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->increment();
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->increment(2);

        $spy->shouldHaveReceived('increment')->with('stat', 0.5, 'tags', 1);
        $spy->shouldHaveReceived('increment')->with('stat', 0.5, 'tags', 2);
    }

    /**
     * @test
     */
    public function it_delegates_the_fluent_decrement_call_to_the_statsd_instance()
    {
        $dataDog = new DataDogDouble($this->app);
        $dataDog->setStatsdInstance($spy = Mockery::spy(DogStatsd::class));
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->decrement();
        $dataDog->stat('stat')->withSampleRate(0.5)->withTags('tags')->decrement(-2);

        $spy->shouldHaveReceived('decrement')->with('stat', 0.5, 'tags', -1);
        $spy->shouldHaveReceived('decrement')->with('stat', 0.5, 'tags', -2);
    }
}
