<?php

namespace JSHayes\LaravelDataDogStatsd\Helpers;

use Illuminate\Support\Collection;

class TagNormalizer
{
    /**
     * Normalize the given tags to an array representation
     *
     * @param array|string|null $tags
     *
     * @return array|null
     */
    public static function normalize($tags): ?array
    {
        if (is_string($tags)) {
            return (new Collection(explode(',', $tags)))->mapWithKeys(function ($tag) {
                [$key, $value] = array_pad(explode(':', $tag, 2), 2, null);
                return [$key => $value];
            })->toArray();
        }

        return $tags;
    }
}
