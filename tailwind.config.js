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
        'title': ['Figtree', 'cursive'],
        'monoton': ['Monoton', 'cursive'],
        'limelight': ['Limelight', 'cursive'],
        'frijole': ['Frijole', 'cursive'],
        'neon': ['Neon', 'cursive'],
      },
      aspectRatio: {
        'a4': '1 / 1.414', // A4サイズの縦横比
      },
      keyframes: {
        slide: {
          '0%': { transform: 'translateX(0%)' },
          '100%': { transform: 'translateX(-50%)' }, // 2セット分の半分を移動
        },
        wiggleAndPulse: {
          '0%, 100%': { transform: 'rotate(-4deg)', opacity: 1 },
          '25%': { transform: 'rotate(6deg)', opacity: 0.25 },
          '50%': { transform: 'rotate(-6deg)', opacity: 1 },
          '75%': { transform: 'rotate(4deg)', opacity: 0.75 },
        }
      },
      animation: {
        'slide-infinite': 'slide 40s linear infinite',
        'wiggle-pulse': 'wiggleAndPulse 3s ease-in-out infinite',
      },
    },
  },

  plugins: [
    forms, typography,
    daisyui,
    //neon効果を持つクラスを追加
    function({ addUtilities, theme }) {
      const newUtilities = {}
      const colors = theme('colors')
      Object.keys(colors).forEach(color => {
        if (typeof colors[color] === 'object') {
          Object.keys(colors[color]).forEach(shade => {
            const className = `.text-${color}-${shade}-neon`
            newUtilities[className] = {
              textShadow: `0 0 5px ${colors[color][shade]}, 0 0 10px ${colors[color][shade]}, 0 0 20px ${colors[color][shade]}`,
            }
          })
        }
      })
      addUtilities(newUtilities, ['responsive', 'hover'])
    },
    function({ addUtilities }) {
      const newUtilities = {
        '.scrollbar-hide': {
          /* Webkit ブラウザ用 */
          '&::-webkit-scrollbar': {
            display: 'none',
          },
          /* Firefox */
          'scrollbar-width': 'none',
          /* IEおよびEdge */
          '-ms-overflow-style': 'none',
        },
      }
      addUtilities(newUtilities, ['responsive'])
    }
  ],
  daisyui: {
    themes: [
      {
        mytheme: {
          'color-scheme': 'dark',
          'primary': 'oklch(70% 0.300 180)',
          'secondary': 'oklch(70% 0.300 200)',
          'accent': 'oklch(90% 0.300 300)',
          'neutral': 'oklch(26% 0.015 260)',
          'neutral-content': 'oklch(70% 0.015 260)',
          'base-100': 'oklch(22% 0.015 260)',
          'base-200': 'oklch(18% 0.015 260)',
          'base-300': 'oklch(14% 0.015 260)',
          'base-content': '#9fb9d0',
          'info': '#89e0eb',
          'success': '#addfad',
          'warning': '#f1c891',
          'error': '#ffbbbd',
        },
      },
    ],
    base: true, // applies background color and foreground color for root element by default
    styled: true, // include daisyUI colors and design decisions for all components
    utils: true, // adds responsive and modifier utility classes
    rtl: false, // rotate style direction from left-to-right to right-to-left. You also need to add dir="rtl" to your html tag and install `tailwindcss-flip` plugin for Tailwind CSS.
    prefix: '', // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
    logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
  },
}
