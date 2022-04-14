/** @type {import('tailwindcss').Config} */

// Tailwind 3 ships JIT by default. No more jit: true needed.
// darkMode: 'class' — toggle with Alpine.js + $persist (survives refresh).
// Custom colors extend the palette — no override, just extend.
// @tailwindcss/forms normalizes inputs across browsers.

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Http/Livewire/**/*.php',
        // Include Blade component classes (dynamic class problem)
        './app/View/Components/**/*.php',
    ],
    safelist: [
        // Dynamic classes used in Livewire components
        'bg-green-50', 'border-green-400', 'text-green-800',
        'bg-red-50', 'border-red-400', 'text-red-800',
        'bg-blue-50', 'border-blue-400', 'text-blue-800',
        'bg-yellow-50', 'border-yellow-400', 'text-yellow-800',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50:  '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                },
            },
            fontFamily: {
                sans: ['Inter var', 'Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            borderRadius: {
                xl: '0.875rem',
                '2xl': '1.25rem',
            },
            boxShadow: {
                'card': '0 1px 3px 0 rgba(0,0,0,0.08), 0 1px 2px -1px rgba(0,0,0,0.04)',
                'card-hover': '0 4px 12px 0 rgba(0,0,0,0.12)',
            },
            animation: {
                'spin-slow': 'spin 2s linear infinite',
                'pulse-fast': 'pulse 1s cubic-bezier(0.4,0,0.6,1) infinite',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms')({
            strategy: 'class', // Use .form-input class instead of global reset
        }),
        // Custom plugin: .prose-tight for compact text
        function({ addComponents }) {
            addComponents({
                '.prose-tight': {
                    'p': { marginTop: '0.5rem', marginBottom: '0.5rem' },
                    'h2': { marginTop: '1.5rem', marginBottom: '0.75rem' },
                },
            });
        },
    ],
};
