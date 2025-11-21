import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
    ],
    // --- TAMBAHAN PENTING BUAT DOCKER/SAIL ---
    server: {
        host: "0.0.0.0", // Izinkan akses dari luar container
        hmr: {
            host: "localhost", // Paksa browser cari ke localhost (bukan 0.0.0.0)
        },
        watch: {
            usePolling: true, // Wajib buat Windows/WSL biar perubahan file terdeteksi
        },
    },
});
