<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Facades;

use Fanmade\NanoId\NanoID as NanoIDGenerator;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Fanmade\NanoId\NanoID
 */
class NanoID extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return NanoIDGenerator::class;
    }
}