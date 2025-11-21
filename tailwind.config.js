import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/**/*.php',
    ],

    safelist: [
        {
            pattern: /(bg|text|border)-(primary|secondary|neutral)-(50|100|200|300|400|500|600|700|800|900)/,
        },
        {
            pattern: /(bg|text|border)-(orange|green|red|blue|yellow|indigo)-(50|100|200|300|400|500|600|700|800|900)/,
        },
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#FFF7ED',
                    100: '#FFEDD5',
                    200: '#FED7AA',
                    300: '#FDBA74',
                    400: '#FB923C',
                    500: '#FF8A00',  // Citrus Orange
                    600: '#E67A00',
                    700: '#C26500',
                    800: '#9A5200',
                    900: '#7C4200',
                },
                secondary: {
                    50: '#F0FDF4',
                    100: '#DCFCE7',
                    200: '#BBF7D0',
                    300: '#86EFAC',
                    400: '#4ADE80',
                    500: '#2F8F4E',  // Fresh Green
                    600: '#267A3E',
                    700: '#1D6330',
                    800: '#154D25',
                    900: '#0F3A1C',
                },
                neutral: {
                    50: '#FAFAFA',
                    100: '#F7F7F7',  // Warm Gray background
                    200: '#E5E5E5',
                    300: '#D4D4D4',
                    400: '#A3A3A3',
                    500: '#737373',
                    600: '#525252',
                    700: '#404040',
                    800: '#262626',
                    900: '#171717',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Poppins', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'lg': '0.75rem',  // 12px for cards
            },
        },
    },

    plugins: [forms],
};
