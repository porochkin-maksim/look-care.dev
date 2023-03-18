/**
 * development and production commands
 * docker-compose exec nodejs npm run dev
 * docker-compose exec nodejs npm run build
 */

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        https: false,
        host: true,
        port: 5173,
        strictPort: true,
        hmr: { host: 'localhost', protocol: 'ws' },
    },
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     https: false,
    //     host: true,
    //     port: 80,
    //     strictPort: true,
    //
    //     hmr: {
    //         host: 'localhost',
    //         protocol: 'ws',
    //         port: 80
    //     },
    // },
});
