<?php

declare(strict_types=1);

namespace Fanmade\NanoId;

use function random_bytes;

class Generator implements Contracts\GeneratorInterface{

    public function random(int $size): array
    {
        // @phpstan-ignore-next-line
        return unpack('C*', random_bytes($size));
    }
}
