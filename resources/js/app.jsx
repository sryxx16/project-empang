import "./bootstrap";
import "../css/app.css";

// TAMBAHKAN INI (Penting buat jaga-jaga biar gak blank)
import React from "react";

import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// Pastikan pakai import.meta.env (Bukan process.env)
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob("./Pages/**/*.jsx")
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);
        // Pastikan React.createElement bisa jalan (Explicit JSX)
        root.render(<App {...props} />);
    },
    progress: {
        color: "#4B5563",
    },
});
