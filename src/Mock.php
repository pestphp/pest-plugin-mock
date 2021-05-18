<?php

declare(strict_types=1);

namespace Pest\Mock;

use Mockery;
use Mockery\MockInterface;
use ReflectionClass;
use ReflectionMethod;

/**
 * @template TObject as object
 *
 * @mixin TObject|MockInterface
 */
final class Mock
{
    /**
     * The object being mocked.
     *
     * @readonly
     *
     * @var TObject|MockInterface
     */
    private object $mock;

    private array $inheritedCalls = [];

    /**
     * Creates a new mock instance.
     *
     * @param class-string<TObject>|TObject $object
     */
    public function __construct(string | object $object)
    {
        /** @var TObject|MockInterface $mock */
        $mock = Mockery::mock($object);

        $this->mock = $mock;
    }

    /**
     * Define mock expectations.
     *
     * @return TObject|MockInterface
     */
    public function expect(callable ...$methods)
    {
        foreach ($methods as $method => $expectation) {
            /* @phpstan-ignore-next-line */
            $method = $this->mock
                ->shouldReceive((string) $method)
                ->atLeast()
                ->once();

            $method->andReturnUsing($expectation);
        }

        $this->buildInheritedCalls();

        return $this->mock;
    }

    public function inherit(object $implementation)
    {
        $mirror = new ReflectionClass($implementation);

        foreach ($mirror->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $this->inheritedCalls[$method->getName()] = $implementation;
        }

        return $this;
    }

    private function buildInheritedCalls()
    {
        foreach ($this->inheritedCalls as $method => $implementation) {
            $this->mock
                ->shouldReceive((string) $method)
                ->andReturnUsing(fn (...$args) => $implementation->$method(...$args));
        }

        $this->inheritedCalls = [];
    }

    /**
     * Proxies calls to the original mock object.
     *
     * @param array<int, mixed> $arguments
     */
    public function __call(string $method, array $arguments): mixed
    {
        $this->buildInheritedCalls();

        /* @phpstan-ignore-next-line */
        return $this->mock->{$method}(...$arguments);
    }
}
