import { basename } from 'node:path'
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';

if (! process.env.APP_URL) {
  process.env.APP_URL = 'http://pes-web.test'
}

const themeDir = process.env.WP_THEME_DIR || basename(import.meta.dirname)

export default defineConfig(({ command }) => {
  if (command === 'build') {
    console.log(`vite: assets will be served from /app/themes/${themeDir}/public/build/`)
  }

  return {
    base: `/app/themes/${themeDir}/public/build/`,
    plugins: [
      laravel({
        input: [
          'resources/css/app.scss',
          'resources/js/app.js',
          'resources/css/editor.scss',
          'resources/js/editor.js',
        ],
        refresh: true,
        assets: ['resources/images/**', 'resources/fonts/**'],
      }),

      wordpressPlugin(),

      wordpressThemeJson({
        disableTailwindColors: true,
        disableTailwindFonts: true,
        disableTailwindFontSizes: true,
        disableTailwindBorderRadius: true,
      }),
    ],
    resolve: {
      alias: {
        '@scripts': '/resources/js',
        '@styles': '/resources/css',
        '@fonts': '/resources/fonts',
        '@images': '/resources/images',
      },
    },
  }
})
