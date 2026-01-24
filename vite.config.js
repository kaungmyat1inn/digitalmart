import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0", // Network ထဲက စက်အားလုံး ဝင်ကြည့်ခွင့်ပေးတာပါ
        hmr: {
            host: "192.168.100.62", // စောစောက ရလာတဲ့ သင့် Mac ရဲ့ IP ကို ဒီမှာ ထည့်ပါ
        },
    },
});
