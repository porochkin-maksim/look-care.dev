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
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
