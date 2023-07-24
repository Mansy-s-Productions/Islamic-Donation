import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: './build',
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
            }
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/style.scss',
                'resources/js/app.js',
                'resources/js/custom.js',
            ],
            refresh: true,
        }),
    ],

});
