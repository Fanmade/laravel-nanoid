<?php
declare(strict_types=1);

namespace Fanmade\NanoId;

use Fanmade\NanoId\Contracts\RandomStringGenerator;
use Fanmade\NanoId\Contracts\ValidatorInterface;
use Fanmade\NanoId\Exceptions\NanoIDException;
use Stringable;
use function config;
use function strlen;

class NanoID implements Stringable
{
    private RandomStringGenerator $generator;
    private int $size;
    private string $alphabet;

    public function __construct(
        RandomStringGenerator $generator = null,
        int $size = null,
        string $alphabet = null,
        private ?ValidatorInterface $validator = null
    )
    {
        $this->generator = $generator ?? app(RandomStringGenerator::class);
        $this->size = $size ?? (int) config('nano-id.size', 21);
        $this->alphabet = $alphabet ?? config('nano-id.alphabet');
    }

    public function generate(int $length = null, string $symbols = null): string
    {
        $limit = (int) ($length > 0 ? $length : $this->size);
        $prefix = config('nano-id.prefix', '');
        $suffix = config('nano-id.suffix', '');
        $prefixLength = config('nano-id.include_prefix_in_length', true) ? strlen($prefix) : 0;
        $suffixLength = config('nano-id.include_suffix_in_length', true) ? strlen($suffix) : 0;
        $idLength = $limit - $prefixLength - $suffixLength;
        if ($idLength <= 0) {
            throw NanoIdException::prefixSuffixTooLong($limit, $prefix, $suffix);
        }
        $symbols = $symbols ?? $this->alphabet;

        // Generate Nano IDs until the validator approves
        do {
            $id = $this->generator->random($idLength, $symbols);
        } while (!($this->validator?->isValid($id) ?? true));

        return "$prefix$id$suffix";
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
