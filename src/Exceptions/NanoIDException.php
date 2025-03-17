<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Exceptions;

use Exception;
use Throwable;

class NanoIDException extends Exception
{
    /**
     * @var array<string, int|string>
     */
    private array $context = [];

    public static function createWithContext(string $message, array $context): static
    {
        $nanoIDException = new static($message);
        $nanoIDException->context = $context;

        return $nanoIDException;
    }

    /**
     * @param array<string, int|string> $context
     */
    public static function fromException(Throwable $exception, array $context = []): self
    {
        $nanoIDException = new self($exception->getMessage(), $exception->getCode(), $exception);
        if (!empty($context)) {
            $nanoIDException->withContext($context);
        }

        return $nanoIDException;
    }

    /**
     * @param array<string, int|string> $context
     */
    public function withContext(array $context): self
    {
        $this->context = $context;

        return $this;
    }

    public static function prefixSuffixTooLong(int $length, ?string $prefix = null, ?string $suffix = null): self
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

    public function addContext(string $key, int|string $value): self
    {
        $this->context[$key] = $value;

        return $this;
    }

    /**
     * @return array<string, int|string>
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
