<?php

namespace Fanmade\NanoId\Contracts;

interface GeneratorInterface
{
    /**
     * @return array<int, int>
     */
    public function random(int $size): array;
}
