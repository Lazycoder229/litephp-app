import { defineConfig } from 'vite';
import fs from 'fs';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';

const hotFile = path.resolve('public/hot');

// Increase limit to prevent MaxListenersExceededWarning on restarts
process.setMaxListeners(0);

let cleanHandler = null;
let sigintHandler = null;
let sigtermHandler = null;

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

                if (cleanHandler) process.removeListener('exit', cleanHandler);
                if (sigintHandler) process.removeListener('SIGINT', sigintHandler);
                if (sigtermHandler) process.removeListener('SIGTERM', sigtermHandler);

                cleanHandler = clean;
                sigintHandler = () => { clean(); process.exit(); };
                sigtermHandler = () => { clean(); process.exit(); };

                process.on('exit', cleanHandler);
                process.on('SIGINT', sigintHandler);
                process.on('SIGTERM', sigtermHandler);

                server.watcher.add([
                    'app/**/*.php',
                    'resources/views/**/*.php'
                ]);

                let reloadTimer = null;
                const pendingFiles = new Set();
                let reloading = false;

                server.watcher.on('change', (file) => {
                    const normalized = file.replace(/\\/g, '/');

                    if (
                        normalized.includes('storage') ||
                        normalized.includes('cache') ||
                        normalized.includes('bootstrap/cache')
                    ) return;

                    if (!normalized.endsWith('.php')) return;
                    if (reloading) return;

                    pendingFiles.add(normalized);
                    clearTimeout(reloadTimer);

                    reloadTimer = setTimeout(() => {
                        reloading = true;
                        console.log('[litephp] PHP changed:', [...pendingFiles]);
                        pendingFiles.clear();
                        server.ws.send({ type: 'full-reload' });
                        setTimeout(() => { reloading = false; }, 500);
                    }, 150);
                });
            },

            buildStart() {
                if (fs.existsSync(hotFile)) fs.rmSync(hotFile);
            }
        }
    ],

    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ]
        }
    },

    server: {
    host: 'localhost',
    port: 5173,
    hmr: {
        host: 'localhost',
        overlay: true
    },

    // ← ito lang ang kailangan, wag nang proxy
    fs: {
        allow: [
            path.resolve('.'),  // buong project root
        ]
    },

    watch: {
        ignored: [
            '**/node_modules/**',
            '**/storage/**',
            '**/bootstrap/cache/**',
            '**/public/build/**',
            path.resolve('vite.config.js'),
            path.resolve('vite.config.ts'),
        ]
    }
},
});