import { createApp, h } from 'vue'
import { createPinia } from 'pinia'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js'
import { createVuetify } from 'vuetify'
import 'vuetify/styles'
import '@/scss/style.scss'
import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar'
import MainLayout from '@/Layouts/MainLayout.vue'
import  PurpleTheme from '@/UI/LightTheme.js';

const vuetify = createVuetify({
    theme: {
        defaultTheme: 'PurpleTheme',
        themes: {
            PurpleTheme
        }
    },
    defaults: {
        VBtn: {},
        VCard: {
            rounded: 'md'
        },
        VTextField: {
            rounded: 'lg'
        },
        VTooltip: {
            location: 'top'
        }
    }
})
createInertiaApp({
  resolve: async (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    const page = await pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || MainLayout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
	  .use(PerfectScrollbarPlugin)
	  .use(createPinia())
      .use(vuetify)
      .mount(el)
  },
})
