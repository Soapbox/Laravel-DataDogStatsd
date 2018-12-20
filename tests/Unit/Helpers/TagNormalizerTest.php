<?php

namespace JSHayes\LaravelDataDogStatsd\Tests\Unit\Helpers;

use JSHayes\LaravelDataDogStatsd\Tests\TestCase;
use JSHayes\LaravelDataDogStatsd\Helpers\TagNormalizer;

class TagNormalizerTest extends TestCase
{
    /**
     * @test
     */
    public function it_normalizes_string_tags_with_no_keys()
    {
        $this->assertSame(['tag1' => null], TagNormalizer::normalize('tag1'));
        $this->assertSame(['tag1' => null, 'tag2' => null], TagNormalizer::normalize('tag1,tag2'));
    }

    /**
     * @test
     */
    public function it_normalizes_string_tags_with_keys()
    {
        $this->assertSame(['key1' => 'tag1'], TagNormalizer::normalize('key1:tag1'));
        $this->assertSame(['key1' => 'tag1', 'key2' => 'tag2'], TagNormalizer::normalize('key1:tag1,key2:tag2'));
    }

    /**
     * @test
     */
    public function it_normalizes_string_tags()
    {
        $this->assertSame(['key1' => 'tag1', 'tag2' => null], TagNormalizer::normalize('key1:tag1,tag2'));
    }

    /**
     * @test
     */
    public function it_does_not_modify_array_tags()
    {
        $this->assertSame(['tag1' => null], TagNormalizer::normalize(['tag1' => null]));
        $this->assertSame(['key1' => 'tag1'], TagNormalizer::normalize(['key1' => 'tag1']));
        $this->assertSame(
            ['key1' => 'tag1', 'tag2' => null],
            TagNormalizer::normalize(['key1' => 'tag1', 'tag2' => null])
        );
    }
}
