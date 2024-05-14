<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Generator;

use Fanmade\NanoId\Contracts\RandomStringGenerator;

/**
 * This is a simple random string generator, using PHP's built-in random_int() function
 */
class SimpleStringGenerator implements RandomStringGenerator
{
    public function getName(): string
    {
        return 'simple';
    }

    public function random(int $size, string $alphabet): string
    {
        $length = strlen($alphabet);
        $result = '';
        for ($i = 0; $i < $size; $i++) {
            $result .= $alphabet[random_int(0, $length - 1)];
        }

        return $result;
    }
}
