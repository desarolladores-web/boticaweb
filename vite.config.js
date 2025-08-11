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
                "resources/css/admin.css", // <-- este nuevo
            ],

            refresh: true,
            useBuildDirectory: false, // Evita la carpeta .vite
        }),
    ],
    build: {
        outDir: "public/build",
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            output: {
                entryFileNames: "assets/[name]-[hash].js",
                chunkFileNames: "assets/[name]-[hash].js",
                assetFileNames: "assets/[name]-[hash][extname]",
            },
        },
    },
});
