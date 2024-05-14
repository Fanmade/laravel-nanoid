<?php

use Fanmade\NanoId\Exceptions\NanoIDException;

it('can be created from a normal exception', function () {
    $exception = new Exception('Test exception');
    $nanoIDException = NanoIDException::fromException($exception);

    expect($nanoIDException->getMessage())->toBe('Test exception')
        ->and($nanoIDException->getCode())->toBe(0)
        ->and($nanoIDException->getPrevious())->toBe($exception);
});

it('can be created with a context', function () {
    $exception = new Exception('Test exception');
    $nanoIDException = NanoIDException::fromException($exception, ['key' => 'value']);

    expect($nanoIDException->getContext())->toBe(['key' => 'value']);
});

it(
    'can create a specific exception for a prefix and suffix that are too long', function () {
    $exception = NanoIDException::prefixSuffixTooLong(10, 'prefix', 'suffix');

    expect($exception->getMessage())->toBe(
        'The combined length of the prefix and suffix is longer than the requested length.'
    )
        ->and($exception->getContext())->toBe(
            [
                'requested_length' => 10,
                'prefix' => 'prefix',
                'suffix' => 'suffix',
                'combined_length' => 12,
            ]
        );
});

it('can receive more context', function () {
    $sut = new NanoIDException('Test exception');
    $sut->addContext('key', 'value');
    $sut->addContext('key2', 'value2');

    expect($sut->getContext())->toBe(
        [
            'key' => 'value',
            'key2' => 'value2',
        ]
    );
});