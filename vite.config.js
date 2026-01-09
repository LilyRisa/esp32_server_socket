import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        host: 'esp32-device.cm', // 👈 QUAN TRỌNG
        port: 5173,
        strictPort: true,
        cors: true,
    },
  plugins: [
    react(),
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/react/main.jsx',
      ],
      refresh: true,
    }),
    
  ],
});