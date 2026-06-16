import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        rollupOptions: {
            external: ['leaflet'],
            output: {
                globals: { leaflet: 'L' },
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/auth.css',
                'resources/css/pages.css',
                'resources/css/map.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/admin-pages.js',
                'resources/js/pages.js',
                'resources/js/map.js',
            ],
            refresh: true,
        }),
    ],
});
