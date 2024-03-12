<?php

// Laravel 11: slim application bootstrap.
// The old app/Http/Kernel.php and app/Console/Kernel.php are gone.
// Middleware registration, exception handling, and routing are all
// configured here in a fluent API.
//
// Migration notes (L10 → L11):
//   - app/Http/Kernel.php         → deleted (middleware in withMiddleware())
//   - app/Console/Kernel.php      → deleted (schedules in routes/console.php)
//   - app/Exceptions/Handler.php  → deleted (exceptions in withExceptions())
//   - config/app.php providers[]  → bootstrap/providers.php
//   - ServiceProvider discovery   → automatic (no manual registration needed)

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:     __DIR__.'/../routes/web.php',
        api:     __DIR__.'/../routes/api.php',
        console: __DIR__.'/../routes/console.php',
        health:  '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Livewire 3 requires the Livewire middleware group.
        // In L11 you append to 'web' group directly.
        $middleware->web(append: [
            \Livewire\Middlewares\LivewireMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom exception rendering goes here.
        // Example: $exceptions->render(fn (ModelNotFoundException $e) => response()->json(['error' => 'Not found'], 404));
    })
    ->create();
