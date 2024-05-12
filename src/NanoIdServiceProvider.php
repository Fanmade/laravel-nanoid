<?php

declare(strict_types=1);

namespace Fanmade\NanoId;

use Fanmade\NanoId\Contracts\GeneratorInterface;
use Illuminate\Support\ServiceProvider;

class NanoIdServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/nano-id.php' => config_path('nano-id.php'),
        ]);
    }

    public function register(): void
    {
        $this->app->bind('nanoId', static fn() => new NanoId());
        $this->app->bind(GeneratorInterface::class, static fn() => new Generator());

        $this->mergeConfigFrom(__DIR__ . '/../config/nano-id.php', 'nano-id');
    }
}