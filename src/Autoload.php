<?php

declare(strict_types=1);

use Pest\Mock\Mock;

if (! function_exists('mock')) {
    /**
     * Creates a new mock with the given class or object.
     *
     * @template TObject as object
     *
     * @param  class-string<TObject>|TObject  $object
     * @return Mock<TObject>
     */
    function mock(string|object $object): Mock
    {
        return new Mock($object);
    }
}
