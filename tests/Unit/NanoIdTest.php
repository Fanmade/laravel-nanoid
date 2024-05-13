<?php

use Fanmade\NanoId\NanoId;

it('can generate a Nano ID', function () {
    $generator = new NanoId();
    $id = $generator->generate();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(21);
});

it('can be generated with a custom length', function () {
    $generator = new NanoId();
    $id = $generator->generate(10);

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(10);
});

it ('can be generated with a custom alphabet', function () {
    $generator = new NanoId();
    $id = $generator->generate(10, 'abc');

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(10)
        ->and($id)->toMatch('/^[abc]+$/');
});

it ('can be generated using the facade', function () {
    $id = \Fanmade\NanoId\Facades\NanoId::generate();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(21);
});

it ('can be generated using the helper', function () {
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(21);
});

it ('can be generated using the helper with a custom length', function () {
    $id = nano_id(10);

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(10);
});

it ('can be generated using the helper with a custom alphabet', function () {
    $id = nano_id(10, 'abc');

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(10)
        ->and($id)->toMatch('/^[abc]+$/');
});

it ('can be configured to have a custom prefix', function () {
    config()->set('nano-id.prefix', 'prefix-');
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(28)
        ->and($id)->toMatch('/^prefix-[a-zA-Z0-9_-]+$/');
});

it ('can be configured to have a custom suffix', function () {
    config()->set('nano-id.suffix', '-suffix');
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(28)
        ->and($id)->toMatch('/^[a-zA-Z0-9_-]+-suffix$/');
});

it ('can be configured to have a custom prefix and suffix', function () {
    config()->set('nano-id.prefix', 'prefix-');
    config()->set('nano-id.suffix', '-suffix');
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(35)
        ->and($id)->toMatch('/^prefix-[a-zA-Z0-9_-]+-suffix$/');
});

it ('can be configured to use a custom validator', function () {
    $validator = new class implements \Fanmade\NanoId\Contracts\ValidatorInterface {
        public function isValid(string $id): bool
        {
            return $id === 'abc';
        }
    };

    $generator = new NanoId(validator: $validator);
    $id = $generator->generate(3, 'abc');

    expect($id)->toBe('abc');
});

it ('can set a validator using a fluent interface', function () {
    $validator = new class implements \Fanmade\NanoId\Contracts\ValidatorInterface {
        public function isValid(string $id): bool
        {
            return $id === 'abc';
        }
    };
    $id = \Fanmade\NanoId\Facades\NanoId::validator($validator)->generate(3, 'abc');

    expect($id)->toBe('abc');
});