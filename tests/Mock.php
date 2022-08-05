<?php

use Mockery\CompositeExpectation;
use Mockery\MockInterface;

class Http
{
    public function __construct(public int $mockArg = 0)
    {
    }

    public function get(): string
    {
        return '';
    }
}

it('can mock methods', function () {
    $mock = mock(Http::class)->expect(
        get: fn () => 'foo',
    );

    expect($mock->get())->toBe('foo');
});

it('can access to arguments', function () {
    $mock = mock(Http::class)->expect(
        get: fn ($foo) => $foo,
    );

    expect($mock->get('foo'))->toBe('foo');
});

it('allows access to the underlying mockery mock', function () {
    $mock = mock(Http::class);

    expect($mock->expect())->toBeInstanceOf(MockInterface::class);
    expect($mock->shouldReceive('get'))->toBeInstanceOf(CompositeExpectation::class);
});

it('passes the arguments to the underlying mock correctly', function () {
    $mock = mock(Http::class);

    $mock->shouldReceive('get')
        ->atLeast()
        ->once()
        ->andReturn('foo');

    expect($mock->get())->toBe('foo');
});

it('passes the arguments to mock constructor', function () {
    $mock = mock(Http::class, [1])->makePartial();

    expect($mock->mockArg)->toBe(1);
});
