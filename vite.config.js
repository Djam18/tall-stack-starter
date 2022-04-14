import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Vite 3 + Laravel plugin.
// HMR works out of the box. No webpack config needed.
// Before: mix.js('resources/js/app.js').postCss('resources/css/app.css')
// Now: just list the entrypoints. Vite handles the rest.

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // Auto-refresh on Blade/PHP changes
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
    },
});
