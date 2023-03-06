/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/js/**/*.{vue,js}"],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'dogger-orange': {
                    '50': '#fff6ed',
                    '100': '#ffead4',
                    '200': '#ffd1a8',
                    '300': '#ffb170',
                    '400': '#ff8437',
                    '500': '#ff5f0b',
                    '600': '#f04706',
                    '700': '#c73207',
                    '800': '#9e290e',
                    '900': '#7f250f',
                },
                'dogger-gray': '#666666',
                'dogger-light-gray': '#F5F5F5',
            }
        },
    },
    plugins: [],
};