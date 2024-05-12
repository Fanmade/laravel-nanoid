<?php
declare(strict_types=1);

namespace Fanmade\NanoId;

use Fanmade\NanoId\Contracts\GeneratorInterface;

class NanoId
{
    private GeneratorInterface $generator;
    private int $length;

    private string $symbols;

    public function __construct(
        GeneratorInterface $generator = null,
        int $length = null,
        string $symbols = null
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

        $nanoId = '';
        while (true) {
            $bytes = $this->generator->random($step);
            foreach ($bytes as $byte) {
                $byte &= $mask;
                if (isset($symbols[$byte])) {
                    $nanoId .= $symbols[$byte];
                    if (strlen($nanoId) >= $length) {
                        return $nanoId;
                    }
                }
            }
        }
    }
}