import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.js',
      ssr: 'resources/js/ssr.js',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    AutoImport({
      imports: ['vue'],
    }),
    Components({
      dirs: ['resources/js'],
      resolvers: [
        (name) => {
          if (name == 'Icon')
            return { name, from: '@iconify/vue' }
        },
      ],
    }),

  ],
  server: {
    hmr: {
      host: 'localhost',
    },
    watch: {
      usePolling: true
    }
  }
})
