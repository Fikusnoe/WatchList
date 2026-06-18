import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

let host_key, host_cert;
try {
    host_key = fs.readFileSync('storage/app/private/dev-vite.key');
    host_cert = fs.readFileSync('storage/app/private/dev-vite.crt');
} catch (e) {
    
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        cors: true,
        origin: 'https://watchlist.fgsfds.ai-info.ru:5173',
        https: host_key && host_cert ? {
            key: host_key,
            cert: host_cert,
        } : false,
        hmr: {
            host: 'watchlist.fgsfds.ai-info.ru',
            protocol: 'wss',
        }
    }
});