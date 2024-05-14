<?php

namespace Fanmade\NanoId\Contracts;

interface RandomStringGenerator
{
    public function getName(): string;
    public function random(int $size, string $alphabet): string;
}
