/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Roboto', 'sans-serif']
            },
            colors: {
                'mhoc': {  DEFAULT: '#006B3C',  '50': '#24FF9F',  '100': '#0FFF96',  '200': '#00E581',  '300': '#00BD6A',  '400': '#009453',  '500': '#006B3C',  '600': '#00331D',  '700': '#000000',  '800': '#000000',  '900': '#000000'},
            }
        },
    },
    plugins: [],
}
