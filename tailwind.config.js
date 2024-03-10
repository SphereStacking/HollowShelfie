import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import daisyui from 'daisyui'
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './node_modules/vue-tailwind-datepicker/**/*.js',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'vtd-primary': colors.sky, // Light mode Datepicker color
        'vtd-secondary': colors.gray, // Dark mode Datepicker color
      },
      aspectRatio: {
        'a4': '1 / 1.414', // A4サイズの縦横比
      },
      keyframes: {
        slide: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-50%)' }, // 2セット分の半分を移動
        },
      },
      animation: {
        'slide-infinite': 'slide 40s linear infinite',
      },
    },
  },

  plugins: [
    forms, typography,
    daisyui,
  ],
  daisyui: {
    themes: [
      {
        mytheme: {
          'color-scheme': 'dark',
          'primary': '#9FE88D',
          'secondary': '#FF7D5C',
          'accent': '#C792E9',
          'neutral': '#B2CCD6',
          'neutral-content': '#1c212b',
          'base-100': '#2A303C',
          'base-200': '#242933',
          'base-300': '#20252E',
          'base-content': '#B2CCD6',
          'info': '#28ebff',
          'success': '#62efbd',
          'warning': '#efd057',
          'error': '#ffae9b',
        },
      },
      'dim',
      'nord',
      'light',
      'dark',
      'cupcake',
      'emerald',
      'garden',
      'pastel',
      'wireframe',
      'cmyk',
      'lemonade',
      'night',
      'winter',
    ],
    // themes: true, // true: all themes | false: only light + dark | array: specific themes like this ["light", "dark", "cupcake"]
    darkTheme: 'dim', // name of one of the included themes for dark mode
    base: true, // applies background color and foreground color for root element by default
    styled: true, // include daisyUI colors and design decisions for all components
    utils: true, // adds responsive and modifier utility classes
    rtl: false, // rotate style direction from left-to-right to right-to-left. You also need to add dir="rtl" to your html tag and install `tailwindcss-flip` plugin for Tailwind CSS.
    prefix: '', // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
    logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
  },
}
