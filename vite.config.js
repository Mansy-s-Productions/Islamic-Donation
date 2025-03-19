import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                entryFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            },
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
