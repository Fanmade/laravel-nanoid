<?php

declare(strict_types=1);

namespace Fanmade\NanoId\Tests;

use Fanmade\NanoId\NanoIdServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class Testcase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            NanoIdServiceProvider::class,
        ];
    }
}