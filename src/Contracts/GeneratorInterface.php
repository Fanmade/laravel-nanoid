<?php

namespace Fanmade\NanoId\Contracts;

interface GeneratorInterface
{
    public function random(int $size): array;
}