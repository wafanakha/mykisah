<?php

namespace App\Providers;

use App\Models\Kisah;
use App\Policies\KisahPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        Kisah::class => KisahPolicy::class,
    ];


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
