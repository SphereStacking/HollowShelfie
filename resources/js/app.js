import './bootstrap'
import '../css/app.css'

import { createSSRApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { i18nVue } from 'laravel-vue-i18n'
const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createSSRApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(i18nVue, {
        lang: 'ja',
        resolve: lang => {
          const langs = import.meta.glob('../lang/*.json', { eager: true })
          return langs[`../lang/${lang}.json`].default
        },
      })
      .mount(el)
  },
  progress: {
    color: '#bbffcc',
  },
})
