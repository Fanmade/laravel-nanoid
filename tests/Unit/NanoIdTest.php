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