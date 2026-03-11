import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    darkest: '#0B0F19', // Main background
                    dark: '#151924',    // Sidebar, Panels
                    card: '#1C212E',    // Cards, Inner elements
                    accent: '#6366f1',  // Indigo accent
                    accentHover: '#4f46e5',
                }
            }
        },
    },

    plugins: [forms],
};
