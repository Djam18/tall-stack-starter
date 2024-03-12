<?php

// Laravel 11: explicit provider list replaces config/app.php providers[].
// Third-party packages that don't support auto-discovery go here.
//
// Most modern packages (Livewire, Breeze) auto-discover via
// composer.json "extra.laravel.providers" — no manual registration needed.

return [
    App\Providers\AppServiceProvider::class,
];
