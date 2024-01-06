<?php

namespace App\Helpers;

class Arrays
{
    /**
     * Is there at least 1 element from the first array in the second.
     *
     * @param array $target
     * @param array $haystack
     *
     * @return bool
     */
    public static function oneOfSeveralInArray(array $target, array $haystack = []): bool
    {
        if ($haystack) {
            foreach ($target as $item) {
                if (array_search($item, $haystack)) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function getArrayOrConvertStringToArray(string|array $value = []): array
    {
        return is_array($value) ? $value : json_decode($value ?? '[]', true);
    }

    public static function getFormattedIds(string $model, string|array $requestIds = []): array
    {
        $existsIds = $model::select('id')->pluck('id')->toArray();
        $items = Arrays::getArrayOrConvertStringToArray($requestIds);

        return array_values(array_intersect($items, $existsIds));
    }
}