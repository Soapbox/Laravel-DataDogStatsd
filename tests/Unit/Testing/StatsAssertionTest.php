<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit\Testing;

use PHPUnit\Framework\AssertionFailedError;
use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Testing\StatsAssertion;
use JSHayes\LaravelDataDogStatsd\Testing\StatsCollection;

class StatsAssertionTest extends TestCase
{
    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_that_is_not_in_the_collection_fails()
    {
        try {
            new StatsAssertion(new StatsCollection(), 'stat');
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_that_is_in_the_collection_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'test');
        new StatsAssertion($collection, 'stat');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_and_value_that_is_in_the_collection_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'test');
        (new StatsAssertion($collection, 'stat'))->withValue('test');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_and_value_that_is_not_in_the_collection_fails()
    {
        $collection = (new StatsCollection())->add('stat', 'test');
        try {
            (new StatsAssertion($collection, 'stat'))->withValue('other');
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_and_tags_that_is_in_the_collection_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'test', 1.0, 'tags');
        (new StatsAssertion($collection, 'stat'))->withTags('tags');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_and_tags_that_is_not_in_the_collection_fails()
    {
        $collection = (new StatsCollection())->add('stat', 'test', 1.0, 'tags');
        try {
            (new StatsAssertion($collection, 'stat'))->withTags('other');
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_and_value_and_tags_that_is_in_the_collection_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'test', 1.0, 'tags');
        (new StatsAssertion($collection, 'stat'))->withValue('test')->withTags('tags');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_that_exists_multiple_times_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'value1', 1.0, 'tag1')
            ->add('stat', 'value2', 1.0, 'tag2');
        new StatsAssertion($collection, 'stat');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_for_the_correct_number_of_times_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'value1', 1.0, 'tag1')
            ->add('stat', 'value2', 1.0, 'tag2');
        (new StatsAssertion($collection, 'stat'))->times(2);
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_for_the_incorrect_number_of_times_fails()
    {
        $collection = (new StatsCollection())->add('stat', 'value1', 1.0, 'tag1')
            ->add('stat', 'value2', 1.0, 'tag2');
        try {
            (new StatsAssertion($collection, 'stat'))->times(3);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_certain_number_of_times_succeeds()
    {
        $collection = (new StatsCollection())->add('stat', 'value1', 1.0, 'tag1')
            ->add('stat', 'value1', 1.0, 'tag1')
            ->add('stat', 'value1', 1.0, 'tag2')
            ->add('stat', 'value2', 1.0, 'tag1');
        (new StatsAssertion($collection, 'stat'))->withValue('value1')->withTags('tag1')->times(2);
    }

    /**
     * @test
     */
    public function creating_an_assertion_for_a_stat_for_the_incorrect_sample_rate_fails()
    {
        $collection = (new StatsCollection())->add('stat', 'value1', 1.0, 'tag1');
        try {
            (new StatsAssertion($collection, 'stat'))->withSampleRate(0.5);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }
}
