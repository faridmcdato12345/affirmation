import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import vue from '@vitejs/plugin-vue';
import eslintPlugin from 'vite-plugin-eslint'
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                entryFileNames: '[name].js',
                assetFileNames: '[name].[ext]',
            },
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        eslintPlugin(),
        VitePWA({ 
            strategies: 'injectManifest',
            srcDir: 'public',
            filename: 'serviceworker.js',
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg}']
            },
            injectManifest: {
                injectionPoint: undefined
            },
            devOptions: {
                enabled: true,
                type: 'module'
            }
        })
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
        },
    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            "~vanilla-lazyload": path.resolve(__dirname, 'node_modules/vanilla-lazyload'),
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue.es')
        },
    }
});
