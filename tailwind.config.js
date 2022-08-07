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
    daisyui: {
        themes: [
            {
                mhoc: {
                    "primary": "#2185d0",
                    "mhoc": "#006B3C",
                    "base-100": "#FFFFFF",
                    "neutral": "#d1d5db",
                    "info": "#3ABFF8",
                    "success": "#36D399",
                    "warning": "#FBBD23",
                    "error": "#F87272",
                    "--rounded-box": "0.5rem", // border radius rounded-box utility class, used in card and other large boxes
                    "--rounded-btn": "0.2rem", // border radius rounded-btn utility class, used in buttons and similar element
                    "--rounded-badge": "1.9rem", // border radius rounded-badge utility class, used in badges and similar
                    "--animation-btn": "0.25s", // duration of animation when you click on button
                    "--animation-input": "0.2s", // duration of animation for inputs like checkbox, toggle, radio, etc
                    "--btn-text-case": "normal-case", // set default text transform for buttons
                    "--btn-focus-scale": "0.95", // scale transform of button when you focus on it
                    "--border-btn": "0", // border width of buttons
                    "--tab-border": "1px", // border width of tabs
                    "--tab-radius": "0.5rem", // border radius of tabs
                },
            }
        ]
    },
    plugins: [
        require("@tailwindcss/typography"),
        require("daisyui")
    ],
}
