<?php

declare(strict_types=1);

namespace Fanmade\NanoId;

use Fanmade\NanoId\Contracts\RandomStringGenerator;
use Illuminate\Support\ServiceProvider;

class NanoIdServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/nano-id.php' => config_path('nano-id.php'),
            ]
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nano-id.php', 'nano-id');

        $generatorClassName = config('nano-id.generator');
        $this->app->bind('nanoId', static fn() => new NanoID());
        $this->app->bind(RandomStringGenerator::class, static fn() => new $generatorClassName());
    }
}
