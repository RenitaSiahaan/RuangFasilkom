const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // Define your bright, vibrant colors here
                'primary-blue': '#4A90E2',      // A good primary blue for buttons, accents
                'secondary-green': '#50E3C2',   // A vibrant green for secondary elements
                'light-card-bg': '#FFFFFF',     // Pure white for the login card background
                'dark-text': '#333333',         // Dark gray for main text on light backgrounds
                'light-text': '#666666',        // Lighter gray for secondary text
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // Optional: Add a custom font for headers if you plan to import one
                // Example: 'pixel': ['"Press Start 2P"', 'cursive'],
                // To use this, you'd need to import the font in resources/css/app.css:
                // @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
                // Then you can use class="font-pixel"
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};