<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Exceptions;

use Exception;
use Throwable;

class NanoIDException extends Exception
{
    private array $context = [];

    public static function fromException(Throwable $exception, array $context = []): self
    {
        $nanoIDException = new self($exception->getMessage(), $exception->getCode(), $exception);
        if (!empty($context)) {
            $nanoIDException->withContext($context);
        }

        return $nanoIDException;
    }

    public function withContext(array $context): self
    {
        $this->context = $context;

        return $this;
    }

    public static function prefixSuffixTooLong(int $length, string $prefix = null, string $suffix = null): self
    {
        $nanoIDException = new self(
            'The combined length of the prefix and suffix is longer than the requested length.'
        );

        $nanoIDException->addContext('requested_length', $length);
        if ($prefix !== null) {
            $nanoIDException->addContext('prefix', $prefix);
        }
        if ($suffix !== null) {
            $nanoIDException->addContext('suffix', $suffix);
        }
        $nanoIDException->addContext('combined_length', strlen("$prefix$suffix"));

        return $nanoIDException;
    }

    public function addContext(string $key, mixed $value): self
    {
        $this->context[$key] = $value;

        return $this;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}