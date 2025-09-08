import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    base: "",
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/css/welcome.css",
                "resources/sass/footer.scss",
                "resources/css/login.css",
                "resources/css/admin.css",
                "resources/css/edit.css", // <--- agrega este
            ],

            refresh: true,
        }),
    ],
    build: {
        outDir: "public/build",
        emptyOutDir: true,
        manifest: "manifest.json", // 👈 fuerza nombre
        rollupOptions: {
            output: {
                entryFileNames: "assets/[name]-[hash].js",
                chunkFileNames: "assets/[name]-[hash].js",
                assetFileNames: "assets/[name]-[hash][extname]",
            },
        },
    },
});
