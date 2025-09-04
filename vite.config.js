import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/RegisteredId.js',
                'resources/js/UserType.js',
                'resources/js/Visitors.js',
                'resources/js/User.js',       // Add this line
                'resources/js/VisitorType.js', // Add this line
                'resources/js/Reports.js', 
                   // Add this line
            ],
            refresh: true,
        }),
    ],
});