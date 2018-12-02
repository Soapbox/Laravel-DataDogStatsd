<?php

namespace JSHayes\LaravelDataDogStatsd;

use DataDog\DogStatsd;

class StatBuilder
{
    private $statsd;
    private $stat;
    private $sampleRate = 1.0;
    private $tags = null;

    /**
     * Create a new metric builder
     *
     * @param \DataDog\DogStatsd $statsd
     * @param string $stat
     */
    public function __construct(DogStatsd $statsd, string $stat)
    {
        $this->statsd = $statsd;
        $this->stat = $stat;
    }

    /**
     * Apply the given tags to this stat
     *
     * @param array|string $tags
     *
     * @return self
     */
    public function withTags($tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Use the given sample rate for this stat
     *
     * @param array|string $tags
     *
     * @return self
     */
    public function withSampleRate(float $sampleRate): self
    {
        $this->sampleRate = $sampleRate;
        return $this;
    }

    /**
     * Log timing information
     *
     * @param float $time
     *
     * @return void
     */
    public function timing(float $time): void
    {
        $this->statsd->timing($this->stat, $time, $this->sampleRate, $this->tags);
    }

    /**
     * A convenient alias for the timing function when used with micro-timing
     *
     * @param float $time
     *
     * @return void
     */
    public function microtiming(float $time): void
    {
        $this->statsd->microtiming($this->stat, $time, $this->sampleRate, $this->tags);
    }

    /**
     * Gauge
     *
     * @param float $value
     *
     * @return void
     */
    public function gauge(float $value): void
    {
        $this->statsd->gauge($this->stat, $value, $this->sampleRate, $this->tags);
    }

    /**
     * Histogram
     *
     * @param float $value
     *
     * @return void
     */
    public function histogram(float $value): void
    {
        $this->statsd->histogram($this->stat, $value, $this->sampleRate, $this->tags);
    }

    /**
     * Distribution
     *
     * @param float $value
     *
     * @return void
     */
    public function distribution(float $value): void
    {
        $this->statsd->distribution($this->stat, $value, $this->sampleRate, $this->tags);
    }

    /**
     * Set
     *
     * @param float $value
     *
     * @return void
     */
    public function set(float $value): void
    {
        $this->statsd->set($this->stat, $value, $this->sampleRate, $this->tags);
    }

    /**
     * Increment a stat counter
     *
     * @param int $value
     *
     * @return void
     */
    public function increment(int $value = 1): void
    {
        $this->statsd->increment($this->stat, $this->sampleRate, $this->tags, $value);
    }

    /**
     * Decrement a stat counter
     *
     * @param int $value
     *
     * @return void
     */
    public function decrement(int $value = -1): void
    {
        $this->statsd->decrement($this->stat, $this->sampleRate, $this->tags, $value);
    }
}
