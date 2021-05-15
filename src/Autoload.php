<?php

declare(strict_types=1);

use Pest\Mock\Mock;

if (!function_exists('mock')) {
    /**
     * Creates a new mock with the given class or object.
     *
     * @param string|object $object
     */
    function mock($object): Mock
    {
        return new Mock($object);
    }
}
