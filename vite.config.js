import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        outDir: "public/build",
        emptyOutDir: true,
    },
    publicDir: false,
    server: {
        https: true, // Força HTTPS no desenvolvimento
    },
    build: {
        manifest: true,
        outDir: "public/build", // <-- ISSO É ESSENCIAL!
        rollupOptions: {
            output: {
                assetFileNames: "build/assets/[name]-[hash][extname]",
                input: "resources/js/app.js",
            },
        },
    },
});
