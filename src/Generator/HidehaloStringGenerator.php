<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Generator;

use Fanmade\NanoId\Contracts\RandomStringGenerator;
use Hidehalo\Nanoid\Client;

/**
 * This uses the original Nano ID generator for PHP, by Hidehalo
 * @see https://github.com/hidehalo/nanoid-php
 */
class HidehaloStringGenerator implements RandomStringGenerator
{
    public function getName(): string
    {
        return 'hidehalo';
    }

    public function random(int $size, string $alphabet): string
    {
        return (new Client())->formattedId($alphabet, $size);
    }
}
