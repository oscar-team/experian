<?php

namespace OscarTeam\Experian;
use Illuminate\Support\ServiceProvider;

class ExperianServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/experian.php' => config_path('experian.php')
        ]);
    }

    public function register(): void
    {
        $this->app->singleton(Experian::class, function() {
            return new Experian();
        });
    }
}
