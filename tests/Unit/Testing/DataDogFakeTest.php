<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit\Testing;

use PHPUnit\Framework\AssertionFailedError;
use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Testing\DataDogFake;

class DataDogFakeTest extends TestCase
{
    /**
     * @test
     */
    public function asserting_that_a_stat_was_not_sent_fails_when_the_stat_was_sent()
    {
        $fake = new DataDogFake($this->app);
        $fake->increment('stat');

        $fake->assertStatWasNotSent('other');
        try {
            $fake->assertStatWasNotSent('stat');
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_timing_stat_was_sent_fails_when_the_stat_was_not_sent()
    {
        $fake = new DataDogFake($this->app);
        $fake->timing('stat', 1.0);

        $fake->assertTimingWasSent('stat', 1.0);
        $fake->assertTimingWasSent('stat');
        try {
            $fake->assertTimingWasSent('other', 1.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_timing_stat_was_sent_fails_when_the_stat_was_not_sent_with_the_correct_value()
    {
        $fake = new DataDogFake($this->app);
        $fake->timing('stat', 1.0);

        $fake->assertTimingWasSent('stat', 1.0);
        $fake->assertTimingWasSent('stat');
        try {
            $fake->assertTimingWasSent('stat', 2.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_gauge_stat_was_sent_fails_when_the_stat_was_not_sent()
    {
        $fake = new DataDogFake($this->app);
        $fake->gauge('stat', 1.0);

        $fake->assertGaugeWasSent('stat', 1.0);
        $fake->assertGaugeWasSent('stat');
        try {
            $fake->assertGaugeWasSent('other', 1.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_gauge_stat_was_sent_fails_when_the_stat_was_not_sent_with_the_correct_value()
    {
        $fake = new DataDogFake($this->app);
        $fake->gauge('stat', 1.0);

        $fake->assertGaugeWasSent('stat', 1.0);
        $fake->assertGaugeWasSent('stat');
        try {
            $fake->assertGaugeWasSent('stat', 2.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_histogram_stat_was_sent_fails_when_the_stat_was_not_sent()
    {
        $fake = new DataDogFake($this->app);
        $fake->histogram('stat', 1.0);

        $fake->assertHistogramWasSent('stat', 1.0);
        $fake->assertHistogramWasSent('stat');
        try {
            $fake->assertHistogramWasSent('other', 1.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_histogram_stat_was_sent_fails_when_the_stat_was_not_sent_with_the_correct_value()
    {
        $fake = new DataDogFake($this->app);
        $fake->histogram('stat', 1.0);

        $fake->assertHistogramWasSent('stat', 1.0);
        $fake->assertHistogramWasSent('stat');
        try {
            $fake->assertHistogramWasSent('stat', 2.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_distribution_stat_was_sent_fails_when_the_stat_was_not_sent()
    {
        $fake = new DataDogFake($this->app);
        $fake->distribution('stat', 1.0);

        $fake->assertDistributionWasSent('stat', 1.0);
        $fake->assertDistributionWasSent('stat');
        try {
            $fake->assertDistributionWasSent('other', 1.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_distribution_stat_was_sent_fails_when_the_stat_was_not_sent_with_the_correct_value()
    {
        $fake = new DataDogFake($this->app);
        $fake->distribution('stat', 1.0);

        $fake->assertDistributionWasSent('stat', 1.0);
        $fake->assertDistributionWasSent('stat');
        try {
            $fake->assertDistributionWasSent('stat', 2.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_set_stat_was_sent_fails_when_the_stat_was_not_sent()
    {
        $fake = new DataDogFake($this->app);
        $fake->set('stat', 1.0);

        $fake->assertSetWasSent('stat', 1.0);
        $fake->assertSetWasSent('stat');
        try {
            $fake->assertSetWasSent('other', 1.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_set_stat_was_sent_fails_when_the_stat_was_not_sent_with_the_correct_value()
    {
        $fake = new DataDogFake($this->app);
        $fake->set('stat', 1.0);

        $fake->assertSetWasSent('stat', 1.0);
        $fake->assertSetWasSent('stat');
        try {
            $fake->assertSetWasSent('stat', 2.0);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_stat_was_incremented_fails_when_the_stat_was_not_incremented()
    {
        $fake = new DataDogFake($this->app);
        $fake->increment('stat');

        $fake->assertStatWasIncremented('stat');
        try {
            $fake->assertStatWasIncremented('other');
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_stat_was_incremented_fails_when_the_stat_was_not_incremented_by_the_correct_amount()
    {
        $fake = new DataDogFake($this->app);
        $fake->increment('stat');

        $fake->assertStatWasIncremented('stat');
        try {
            $fake->assertStatWasIncremented('stat', 2);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_stat_was_decremented_fails_when_the_stat_was_not_decremented()
    {
        $fake = new DataDogFake($this->app);
        $fake->decrement('stat');

        $fake->assertStatWasDecremented('stat');
        try {
            $fake->assertStatWasDecremented('other');
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_stat_was_decremented_fails_when_the_stat_was_not_decremented_by_the_correct_amount()
    {
        $fake = new DataDogFake($this->app);
        $fake->decrement('stat');

        $fake->assertStatWasDecremented('stat');
        try {
            $fake->assertStatWasDecremented('stat', 2);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_stat_was_update_fails_when_the_stat_was_not_update()
    {
        $fake = new DataDogFake($this->app);
        $fake->updateStats('stat', 10);

        $fake->assertStatWasUpdated('stat', 10);
        $fake->assertStatWasUpdated('stat');
        try {
            $fake->assertStatWasUpdated('other', 10);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }

    /**
     * @test
     */
    public function asserting_that_a_stat_was_update_fails_when_the_stat_was_not_update_by_the_correct_amount()
    {
        $fake = new DataDogFake($this->app);
        $fake->updateStats('stat', 10);

        $fake->assertStatWasUpdated('stat', 10);
        $fake->assertStatWasUpdated('stat');
        try {
            $fake->assertStatWasUpdated('stat', 1);
        } catch (AssertionFailedError $e) {
            return;
        }

        $this->fail('Expected the assertion to fail.');
    }
}
