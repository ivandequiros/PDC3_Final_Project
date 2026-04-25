import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // Add this

export default defineConfig({
    plugins: [
        tailwindcss(), // Add this
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
