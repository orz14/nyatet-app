const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    darkMode: "class",

    theme: {
        container: {
            center: true,
            padding: "16px",
        },
        extend: {
            fontFamily: {
                sans: ["Quicksand", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                slideInTop: "slideInTop 0.5s",
                slideInDown: "slideInDown 0.5s",
            },
        },
    },

    plugins: [require("@tailwindcss/forms"), require("daisyui")],
};
