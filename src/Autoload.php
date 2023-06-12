<?php

declare(strict_types=1);

use Pest\Mock\Mock;
use Pest\Mock\Mockery\Container;

if (! function_exists('mock')) {
    /**
     * Creates a new mock with the given class or object.
     *
     * @template TObject as object
     *
     * @param  class-string<TObject>|TObject  $object
     * @return Mock<TObject>
     */
    function mock(object|string $object): Mock
    {
        return new Mock($object);
    }
} else {
    $reflection = new ReflectionClass(Mockery::class);

    @file_put_contents(dirname($reflection->getFilename()) . '/helpers.php', '');
}
