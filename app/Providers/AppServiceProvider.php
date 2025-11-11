<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // 👈 Importación NECESARIA
use App\Models\User; // 👈 Importación NECESARIA
use Illuminate\Support\ServiceProvider;

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
        // 1. Definición del Gate 'is-seller'
        Gate::define('is-seller', function (User $user) {
            // Este método llama al helper isSeller() que definimos en el Modelo User
            return $user->isSeller(); 
        });
    }
}