<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema; // Importa la clase Schema
use Illuminate\Support\Facades\URL;    // Importa la clase URL
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Aquí puedes registrar servicios adicionales si es necesario
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS en producción
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Solución a problemas con MySQL y claves foráneas en Laravel
        Schema::defaultStringLength(191);
    }
}
