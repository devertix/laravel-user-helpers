<?php

namespace Devertix\LaravelUserHelpers;

use Devertix\LaravelUserHelpers\Console\Commands\UserAdd;
use Devertix\LaravelUserHelpers\Console\Commands\UserPassword;
use Devertix\LaravelUserHelpers\Console\Commands\UserToken;
use Illuminate\Support\ServiceProvider;

class LaravelUserHelpersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UserAdd::class,
                UserToken::class,
                UserPassword::class,
            ]);
        }
    }
}
