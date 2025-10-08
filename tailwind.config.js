import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'yara-blue': '#00205b',           // PANTONE 281 - Hauptfarbe
                'yara-mid-blue': '#2777b8',       // PANTONE 646 - Mittleres Blau
                'yara-bright-blue': '#63b6e6',    // PANTONE 292 - Helles Blau
                'yara-orange': '#ff8228',         // PANTONE 151 - Orange Akzent
                'yara-dark-green': '#006341',     // Dunkelgrün
                'yara-yellow': '#ffcf01',         // Gelb
                'yara-pale-blue-gray': '#e8f1f5', // Helles Blaugrau für Hintergründe
            },
        },
    },

    plugins: [forms],
};
