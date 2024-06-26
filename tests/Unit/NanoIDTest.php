<?php

use Fanmade\NanoId\NanoID;

it('can generate a Nano ID', function () {
    $generator = new NanoID();
    $id = $generator->generate();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'));
});

it('can be generated with a custom length', function () {
    $generator = new NanoID();
    $id = $generator->generate(10);

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(10);
});

it ('can be generated with a custom alphabet', function () {
    $generator = new NanoID();
    $id = $generator->generate(10, 'abc');

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(10)
        ->and($id)->toMatch('/^[abc]+$/');
});

it ('can be generated using the facade', function () {
    $id = \Fanmade\NanoId\Facades\NanoID::generate();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'));
});

it ('can be generated using the helper', function () {
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'));
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
        ->and(strlen($id))->toBe(config('nano-id.size'))
        ->and($id)->toMatch('/^prefix-[a-zA-Z0-9_-]+$/');
});

it ('can be configured to have a custom suffix', function () {
    config()->set('nano-id.suffix', '-suffix');
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'))
        ->and($id)->toMatch('/^[a-zA-Z0-9_-]+-suffix$/');
});

it ('can be configured to have a custom prefix and suffix', function () {
    config()->set('nano-id.prefix', 'prefix-');
    config()->set('nano-id.suffix', '-suffix');
    $id = nano_id();

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'))
        ->and($id)->toMatch('/^prefix-[a-zA-Z0-9_-]+-suffix$/');
});

it ('can be configured to use a custom validator', function () {
    $validator = new class implements \Fanmade\NanoId\Contracts\ValidatorInterface {
        public function isValid(string $id): bool
        {
            return $id === 'abc';
        }
    };

    $generator = new NanoID(validator: $validator);
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
    $id = \Fanmade\NanoId\Facades\NanoID::validator($validator)->generate(3, 'abc');

    expect($id)->toBe('abc');
});

it('will check for an invalid length', function () {$generator = new NanoID();
    $id = $generator->generate(0);

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'));
});

it('will check for an invalid prefix and suffix', function () {
    config()->set('nano-id.prefix', 'prefix-');
    config()->set('nano-id.suffix', '-suffix');
    nano_id(10);
})->throws(
    \Fanmade\NanoId\Exceptions\NanoIDException::class,
    'The combined length of the prefix and suffix is longer than the requested length.'
);

it ('can be cast to a string', function () {
    $generator = new NanoID();
    $id = (string) $generator;

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(config('nano-id.size'));
});

it ('allow configuring if the prefix should be excluded in the length', function () {
    config()->set('nano-id.prefix', 'prefix-');
    config()->set('nano-id.include_prefix_in_length', false);
    $id = nano_id(30);

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(37)
        ->and($id)->toMatch('/^prefix-[a-zA-Z0-9_-]+$/');
});

it('allow configuring if the suffix should be excluded in the length', function () {
    config()->set('nano-id.suffix', '-suffix');
    config()->set('nano-id.include_suffix_in_length', false);
    $id = nano_id(30);

    expect($id)->toBeString()
        ->and(strlen($id))->toBe(37)
        ->and($id)->toMatch('/^[a-zA-Z0-9_-]+-suffix$/');
});