<?php

namespace JSHayes\LaravelDataDogStatsd\Testing;

use PHPUnit\Framework\Assert;

class StatsAssertion extends Assert
{
    private $stats;
    private $stat;
    private $times;
    private $expectations = [];
    private $messages = [
        'stat' => 'Expected "%s" to be sent',
        'value' => ' with a value of "%s"',
        'tags' => ' with tags %s',
        'sample-rate' => ' with a sample rate of "%s"',
        'times' => ' %s times',
    ];

    /**
     * Make assertions for the given stat
     *
     * @param \Tests\Doubles\DataDog\FakeStatsd $stats
     * @param string $stat
     */
    public function __construct(StatsCollection $stats, string $stat)
    {
        $this->expectations['stat'] = $stat;
        $this->stats = $stats->filterByStat($stat);
    }

    /**
     * Filter the stats to those with the given value
     *
     * @param mixed $value
     *
     * @return self
     */
    public function withValue($value): self
    {
        $this->stats = $this->stats->filterByValue($value);
        $this->expectations['value'] = $value;
        return $this;
    }

    /**
     * Filter the stats to those with the given sample rate
     *
     * @param float $sampleRate
     *
     * @return self
     */
    public function withSampleRate(float $sampleRate): self
    {
        $this->stats = $this->stats->filterBySampleRate($sampleRate);
        $this->expectations['sample-rate'] = $sampleRate;
        return $this;
    }

    /**
     * Assert that the stat was sent with the given tags
     *
     * @param array|string|null $tags
     *
     * @return self
     */
    public function withTags($tags): self
    {
        $this->stats = $this->stats->filterByTags($tags);
        $this->expectations['tags'] = json_encode($tags);

        return $this;
    }

    /**
     * Assert that the stat was sent the given number of times
     *
     * @param int $times
     *
     * @return self
     */
    public function times(int $times): self
    {
        $this->times = $times;
        $this->expectations['times'] = $times;
        return $this;
    }

    /**
     * Execute the assertion
     */
    public function __destruct()
    {
        $message = '';

        foreach ($this->messages as $key => $value) {
            if (array_key_exists($key, $this->expectations)) {
                $message .= sprintf($this->messages[$key], $this->expectations[$key]);
            }
        }

        if (!is_null($this->times)) {
            $this->assertCount($this->times, $this->stats, $message);
        } else {
            $this->assertNotEmpty($this->stats, $message);
        }
    }
}
