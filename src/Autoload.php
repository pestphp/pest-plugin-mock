<?php

declare(strict_types=1);

namespace Pest\Mock;

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
