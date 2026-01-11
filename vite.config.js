import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    darkMode: "class", // Permet d'activer le mode sombre via la classe 'dark'
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/style.css", // Ajoutez cette ligne !
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
