import { fileURLToPath, URL } from 'url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
				compilerOptions: {
					isCustomElement: (tag) => ['v-list-recognize-title'].includes(tag)
				},
                transformAssetUrls,
                base: null,
                includeAbsolute: false
            }
        }),
        vuetify({
            autoImport: true
        })
    ],
    resolve: {
        alias: {
            'ziggy-js': fileURLToPath(new URL('./vendor/tightenco/ziggy', import.meta.url)),
			'@': fileURLToPath(new URL('./resources/js', import.meta.url))
        }
    },
    css: {
        preprocessorOptions: {
            scss: {}
        }
    },
    build: {
        chunkSizeWarningLimit: 5000,
    },
    optimizeDeps: {
        exclude: ['vuetify'],
        entries: ['./resources/js/**/*.vue']
    }
});
