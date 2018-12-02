<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit\Testing;

use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Testing\StatsCollection;

class StatsCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function adding_stats_will_add_them_to_the_collection()
    {
        $collection = new StatsCollection();
        $collection->add('stat1', 'test')
            ->add('stat2', 'test', 1.0, 'tags')
            ->add('stat3', 'other', 1.0, ['key' => 'value']);

        $this->assertEquals([
            ['stat' => 'stat1', 'value' => 'test', 'tags' => null, 'sample-rate' => 1.0],
            ['stat' => 'stat2', 'value' => 'test', 'tags' => 'tags', 'sample-rate' => 1.0],
            ['stat' => 'stat3', 'value' => 'other', 'tags' => ['key' => 'value'], 'sample-rate' => 1.0],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function adding_the_same_stat_multiple_times_will_add_them_to_the_collection_correctly()
    {
        $collection = new StatsCollection();
        $collection->add('stat', 'test')
            ->add('stat', 'test', 1.0, 'tags')
            ->add('stat', 'other', 1.0, ['key' => 'value']);

        $this->assertEquals([
            ['stat' => 'stat', 'value' => 'test', 'tags' => null, 'sample-rate' => 1.0],
            ['stat' => 'stat', 'value' => 'test', 'tags' => 'tags', 'sample-rate' => 1.0],
            ['stat' => 'stat', 'value' => 'other', 'tags' => ['key' => 'value'], 'sample-rate' => 1.0],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function filtering_by_stat_will_remove_all_other_stats()
    {
        $collection = new StatsCollection();
        $collection->add('stat1', 'test')
            ->add('stat1', 'test', 1.0, 'tags')
            ->add('stat2', 'other', 1.0, ['key' => 'value']);

        $collection = $collection->filterByStat('stat1');

        $this->assertEquals([
            ['stat' => 'stat1', 'value' => 'test', 'tags' => null, 'sample-rate' => 1.0],
            ['stat' => 'stat1', 'value' => 'test', 'tags' => 'tags', 'sample-rate' => 1.0],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function filtering_by_value_will_remove_all_stats_with_different_values()
    {
        $collection = new StatsCollection();
        $collection->add('stat1', 'test')
            ->add('stat2', 'test', 1.0, 'tags')
            ->add('stat3', 'other', 1.0, ['key' => 'value']);

        $collection = $collection->filterByValue('test');

        $this->assertEquals([
            ['stat' => 'stat1', 'value' => 'test', 'tags' => null, 'sample-rate' => 1.0],
            ['stat' => 'stat2', 'value' => 'test', 'tags' => 'tags', 'sample-rate' => 1.0],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function filtering_by_sample_rate_will_remove_all_stats_with_different_sample_rates()
    {
        $collection = new StatsCollection();
        $collection->add('stat1', 'test', 1.0)
            ->add('stat2', 'other', 1.0)
            ->add('stat3', 'test', 0.5)
            ->add('stat3', 'another', 0.0);

        $collection = $collection->filterBySampleRate(1.0);

        $this->assertEquals([
            ['stat' => 'stat1', 'value' => 'test', 'tags' => null, 'sample-rate' => 1.0],
            ['stat' => 'stat2', 'value' => 'other', 'tags' => null, 'sample-rate' => 1.0],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function filtering_by_tags_will_remove_all_stats_with_different_tags()
    {
        $collection = new StatsCollection();
        $collection->add('stat1', 'test')
            ->add('stat2', 'test', 1.0, 'tags')
            ->add('stat3', 'other', 1.0, ['key' => 'value'])
            ->add('stat3', 'another', 1.0, 'tags');

        $collection = $collection->filterByTags('tags');

        $this->assertEquals([
            ['stat' => 'stat2', 'value' => 'test', 'tags' => 'tags', 'sample-rate' => 1.0],
            ['stat' => 'stat3', 'value' => 'another', 'tags' => 'tags', 'sample-rate' => 1.0],
        ], $collection->toArray());
    }

    /**
     * @test
     */
    public function filtering_by_multiple_fields_will_return_the_correct_set()
    {
        $collection = new StatsCollection();
        $collection->add('stat1', 'test')
            ->add('stat1', 'test', 1.0, 'tags')
            ->add('stat1', 'other', 1.0, 'tags')
            ->add('stat2', 'test', 1.0, 'tags')
            ->add('stat3', 'other', 1.0, ['key' => 'value']);

        $collection = $collection->filterByStat('stat1')->filterByValue('test')->filterByTags('tags');

        $this->assertEquals([
            ['stat' => 'stat1', 'value' => 'test', 'tags' => 'tags', 'sample-rate' => 1.0],
        ], $collection->toArray());
    }
}
