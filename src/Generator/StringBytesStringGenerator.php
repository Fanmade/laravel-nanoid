<?php /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */

declare(strict_types=1);

namespace Fanmade\NanoId\Randomizers;

use Fanmade\NanoId\Contracts\RandomStringGenerator;
use Fanmade\NanoId\Exceptions\NanoIDException;
use Random\Randomizer;

/**
 * This uses the new PHP 8.3 `Randomizer` class to generate random bytes
 */
class StringBytesStringGenerator implements RandomStringGenerator
{
    public function __construct()
    {
        /** @noinspection ConstantCanBeUsedInspection */
        if (version_compare(PHP_VERSION, '8.3.0', '<')) {
            throw NanoIDException::createWithContext(
                'This generator requires PHP 8.3 or higher',
                [
                    'php_version' => PHP_VERSION,
                ]
            );
        }
    }

    public function getName(): string
    {
        return 'string-bytes';
    }

    public function random(int $size, string $alphabet): string
    {
        return (new Randomizer())->getBytesFromString($alphabet, $size);
    }
}
