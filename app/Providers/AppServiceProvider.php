<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Laravel 11: AppServiceProvider is the only default service provider.
// The old AuthServiceProvider, EventServiceProvider, RouteServiceProvider
// are all removed — their functionality moved inline:
//   - Routes: bootstrap/app.php withRouting()
//   - Events: use Event::listen() here in boot()
//   - Gates/Policies: use Gate::policy() here in boot()
//
// This single provider approach reduces boilerplate significantly.

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
