// JS
import LazyLoad from "~vanilla-lazyload"
import "./bootstrap"
import * as bootstrap from "~bootstrap"
import "./custom"
import Alpine from "alpinejs"

//Inertia Vue
import { createApp, h } from "vue"
import { createInertiaApp } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import { ZiggyVue } from "ziggy"

// CSS
import "../css/app.css"
import "../css/bootstrap.css"
import "../css/style.css"
import "../sass/star_rating.scss"

window.bootstrap = bootstrap
window.LazyLoad = LazyLoad
window.Alpine = Alpine
Alpine.start()

createInertiaApp({
  title: (title) => `${title} Affirm`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .mount(el)
  },
})
