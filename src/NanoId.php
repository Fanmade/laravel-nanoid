<?php
declare(strict_types=1);

namespace Fanmade\NanoId;

use Fanmade\NanoId\Contracts\GeneratorInterface;
use Fanmade\NanoId\Contracts\ValidatorInterface;
use Fanmade\NanoId\Exceptions\NanoIDException;
use Stringable;

class NanoId implements Stringable
{
    private GeneratorInterface $generator;
    private int $size;
    private string $alphabet;

    public function __construct(
        GeneratorInterface $generator = null,
        int $size = null,
        string $alphabet = null,
        private ?ValidatorInterface $validator = null
    )
    {
        $this->generator = $generator ?? app(GeneratorInterface::class);
        $this->size = $size ?? config('nano-id.size');
        $this->alphabet = $alphabet ?? config('nano-id.alphabet');
    }

    public function generate(int $length = null, string $symbols = null): string
    {
        $length = (int) $length > 0 ? $length : $this->size;
        $symbols = $symbols ?? $this->alphabet;
        $alphabetLength = strlen($symbols);
        $mask = (2 << (int) log(($alphabetLength - 1) * 6, 2)) - 1;
        $step = (int) ceil(1.6 * $mask * $length / $alphabetLength);
        $prefix = config('nano-id.prefix', '');
        $suffix = config('nano-id.suffix', '');
        if (strlen("$prefix$suffix") >= $length) {
            throw NanoIdException::prefixSuffixTooLong($length, $prefix, $suffix);
        }

        $nanoId = '';
        while (true) {
            foreach ($this->generator->random($step) as $byte) {
                $byte &= $mask;
                if (!isset($symbols[$byte])) {
                    continue;
                }
                $nanoId .= $symbols[$byte];

                if (strlen($nanoId) < $length) {
                    continue;
                }

                if (!($this->validator?->isValid($nanoId) ?? true)) {
                    $nanoId = '';
                    continue;
                }

                return "$prefix$nanoId$suffix";
            }
        }
    }

    public function validator(ValidatorInterface $validator): self
    {
        $this->validator = $validator;

        return $this;
    }

    public function __toString(): string
    {
        return $this->generate();
    }
}