<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!Stringable::hasMacro('doesntStartWith')) {
        Stringable::macro('doesntStartWith', function ($needles) {
            return ! Str::startsWith($this->value, $needles);
        });
    }
    }
}
