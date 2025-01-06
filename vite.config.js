import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

// Tailwind 4: use the official Vite plugin instead of PostCSS.
// TW4 ships its own Vite plugin that replaces postcss.config.js entirely.
// PostCSS is still used internally but no config needed.
//
// TW3 setup:              TW4 setup:
//   plugins: [laravel()]    plugins: [laravel(), tailwindcss()]
//   postcss.config.js       (deleted)
//   tailwind.config.js      (deleted — config is now in CSS)

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
    },
});
