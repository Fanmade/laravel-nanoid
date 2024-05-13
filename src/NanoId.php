<?php
declare(strict_types=1);

namespace Fanmade\NanoId;

use Fanmade\NanoId\Contracts\GeneratorInterface;
use Fanmade\NanoId\Contracts\ValidatorInterface;

class NanoId
{
    private GeneratorInterface $generator;
    private int $length;

    private string $symbols;

    public function __construct(
        GeneratorInterface $generator = null,
        int $length = null,
        string $symbols = null,
        private ?ValidatorInterface $validator = null
    )
    {
        $this->generator = $generator ?? app(GeneratorInterface::class);
        $this->length = $length ?? config('nano-id.length');
        $this->symbols = $symbols ?? config('nano-id.symbols');
    }

    public function generate(int $length = null, string $symbols = null): string
    {
        $length = $length ?? $this->length;
        $symbols = $symbols ?? $this->symbols;
        $alphabetLength = strlen($symbols);
        $mask = (2 << (int) log(($alphabetLength - 1) * 6, 2)) - 1;
        $step = (int) ceil(1.6 * $mask * $length / $alphabetLength);
        $prefix = config('nano-id.prefix', '');
        $suffix = config('nano-id.suffix', '');

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
}