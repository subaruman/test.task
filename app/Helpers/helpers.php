<?php

if (! function_exists('array_rand_val')) {
    /**
     * Get random value from array
     */
    function array_rand_val(array $arr): mixed
    {
        return $arr[array_rand($arr)];
    }
}
