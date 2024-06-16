import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'

export default defineConfig(({mode})=> {
  return {
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
        dts: 'resources/js/types/auto-imports.d.ts',
        eslintrc: {
          enabled: true,
        },
      }),
      Components({
        dirs: ['resources/js'],
        dts: 'resources/js/types/components.d.ts',
        resolvers: [
          (name) => {
            if (name == 'Icon')
              return { name, from: '@iconify/vue' }
          },
        ],
      }),
    ],
    build: {
      minify: mode === 'production' ? 'esbuild' : false,
    },
    server: {
      hmr: {
        host: 'localhost',
      },
      watch: {
        usePolling: true
      }
    }
  }
})
