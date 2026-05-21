import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { bunny } from "laravel-vite-plugin/fonts";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
            // រក្សាទុកការកំណត់ Fonts ពីទម្រង់ចាស់របស់អ្នក
            fonts: [
                bunny("Instrument Sans", {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        // បន្ថែម Plugin Tailwind CSS ជំនាន់ទី 4 ចូល
        tailwindcss(),
    ],
    // រក្សាទុកការកំណត់ Server ពីទម្រង់ចាស់របស់អ្នក
    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
