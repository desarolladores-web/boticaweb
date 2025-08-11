import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    base: "", // <-- aseguramos base relativa
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true, // solo útil en desarrollo
        }),
    ],
    build: {
        outDir: "public/build",
        manifest: true,
        emptyOutDir: true,
    },
});
