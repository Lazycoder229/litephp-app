import { defineConfig } from 'vite';
import fs from 'fs';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';
const hotFile = path.resolve('public/hot');

export default defineConfig({
    plugins: [
         tailwindcss(),
        {
            name: 'litephp-hot-file',
            configureServer(server) {
                server.httpServer?.once('listening', () => {
                    fs.writeFileSync(hotFile, 'http://localhost:5173');
                });

                const clean = () => {
                    if (fs.existsSync(hotFile)) fs.rmSync(hotFile);
                };
                process.on('exit', clean);
                process.on('SIGINT', () => { clean(); process.exit(); });
                process.on('SIGTERM', () => { clean(); process.exit(); });
            },
            buildStart() {
                if (fs.existsSync(hotFile)) fs.rmSync(hotFile);
            },
            // watch PHP files and trigger full reload
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.php')) {
                    server.ws.send({ type: 'full-reload' });
                    return [];
                }
            },
        },
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
        },
    },
    server: {
        host: 'localhost',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            // watch the entire app folder (includes views)
            paths: ['app/**/*.php'],
        },
    },
});