// tailwind.config.js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "brand-orange": "#f9981b",
                "brand-dark": "#1a1a1a",
                "brand-light": "#f9fafb",
            },
        },
    },
    plugins: [],
};
