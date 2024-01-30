// JS
import LazyLoad from "~vanilla-lazyload"
import "./custom"
import { VueCookieNext } from 'vue-cookie-next'
import { VueQrcodeReader } from "vue-qrcode-reader";

//Inertia Vue
import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faEyeSlash,
  faEye,
  faAngleLeft,
  faLightbulb
} from '@fortawesome/free-solid-svg-icons'

import { options } from './toastOptions'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import rate from 'vue-rate'
import 'vue-rate/dist/vue-rate.css'

// CSS
import "../css/app.css"
import "../css/style.css"
import "../sass/star_rating.scss"
import 'v-onboarding/dist/style.css'

window.LazyLoad = LazyLoad

library.add([
  faEyeSlash,
  faEye,
  faAngleLeft,
  faLightbulb
])
createInertiaApp({
  title: (title) => `${title} - Affirm`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(rate)
      .use(VueCookieNext)
      .use(Toast, options)
      .use(ZiggyVue)
      .use(VueQrcodeReader)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
})
