<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Facades;

use Fanmade\NanoId\NanoId as NanoIdGenerator;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Fanmade\NanoId\NanoId
 */
class NanoId extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return NanoIdGenerator::class;
    }
}