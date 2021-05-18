<?php

use Mockery\CompositeExpectation;
use Mockery\MockInterface;

interface Http
{
    public function get(): string;
}

class TestMock implements Http
{
    public function post($data): mixed
    {
        return $data;
    }

    public function get(): string
    {
        return 'foo';
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

it('can inherit calls from a class', function () {
    $mock = mock(Http::class)->inherit(new TestMock());

    expect($mock->post('foo'))->toBe('foo');
    expect($mock->get())->toBe('foo');
});

it('can override inherited calls', function () {
    $mock = mock(TestMock::class)
        ->inherit(new TestMock())
        ->expect(get: fn () => 'bar');

    expect($mock->get())->toBe('bar');
});
