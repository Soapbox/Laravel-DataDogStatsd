<?php

namespace JSHayes\LaravelDataDogStatsd\Testing;

use Countable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use JSHayes\LaravelDataDogStatsd\Helpers\TagNormalizer;

class StatsCollection implements Countable, Arrayable
{
    /**
     * The collection of stats
     *
     * @var \Illuminate\Support\Collection
     */
    private $stats;

    /**
     * Create a new StatsColletion
     *
     * @param \Illuminate\Support\Collection|null $stats
     */
    public function __construct(Collection $stats = null)
    {
        $this->stats = $stats ?: new Collection();
    }

    /**
     * Add the given stat to the collection
     *
     * @param string $stat
     * @param mixed $value
     * @param array|string|null $tags
     *
     * @return self
     */
    public function add(string $stat, $value, float $sampleRate = 1.0, $tags = null): self
    {
        $this->stats->push([
            'stat' => $stat,
            'value' => $value,
            'sample-rate' => $sampleRate,
            'tags' => TagNormalizer::normalize($tags),
        ]);
        return $this;
    }

    /**
     * Filter this StatsCollection by the given key and value
     *
     * @param string $key
     * @param mixed $value
     *
     * @return \JSHayes\LaravelDataDogStatsd\Testing\StatsCollection
     */
    private function filterBy(string $key, $value): StatsCollection
    {
        return new StatsCollection($this->stats->filter(function ($stat) use ($key, $value) {
            return $stat[$key] == $value;
        })->values());
    }

    /**
     * Filter this StatsCollection by the given stat
     *
     * @param string $stat
     *
     * @return \Tests\Doubles\DataDog\StatsCollection
     */
    public function filterByStat(string $stat): StatsCollection
    {
        return $this->filterBy('stat', $stat);
    }

    /**
     * Filter this StatsCollection by the given value
     *
     * @param mixed $value
     *
     * @return \Tests\Doubles\DataDog\StatsCollection
     */
    public function filterByValue($value): StatsCollection
    {
        return $this->filterBy('value', $value);
    }

    /**
     * Filter this StatsCollection by the given tags
     *
     * @param array|string $tags
     *
     * @return \Tests\Doubles\DataDog\StatsCollection
     */
    public function filterByTags($tags): StatsCollection
    {
        return $this->filterBy('tags', TagNormalizer::normalize($tags));
    }

    /**
     * Filter this StatsCollection by the given sample rate
     *
     * @param float $sampleRate
     *
     * @return \Tests\Doubles\DataDog\StatsCollection
     */
    public function filterBySampleRate(float $sampleRate): StatsCollection
    {
        return $this->filterBy('sample-rate', $sampleRate);
    }

    /**
     * Check to see if this StatsCollection is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->stats->isEmpty();
    }

    /**
     * Check to see if this StatsCollection is not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return $this->stats->isNotEmpty();
    }

    /**
     * Count the number of elements in this StatsCollection
     *
     * @return int
     */
    public function count(): int
    {
        return $this->stats->count();
    }

    /**
     * Convert this StatsCollection into an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->stats->toArray();
    }
}
