// JS
import LazyLoad from "~vanilla-lazyload"
import "./custom"
import { initializeApp } from "@firebase/app";
import { getMessaging, getToken, onMessage  } from "@firebase/messaging";

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

window.LazyLoad = LazyLoad
library.add([
  faEyeSlash,
  faEye,
  faAngleLeft,
  faLightbulb
])
const firebaseConfig = {
  apiKey: 'AIzaSyBGis6onNBKFoppXu-wPxCP5TrsNBVkZXc',
  authDomain: 'affirm-618f9.firebaseapp.com',
  projectId: 'affirm-618f9',
  storageBucket: 'affirm-618f9.appspot.com',
  messagingSenderId: '142532545526',
  appId: '1:142532545526:web:3715ccaf284865529815d7',
  measurementId: 'G-ZT5ZLC9V4W'
}

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const messaging = getMessaging(app);

const token = getToken(messaging, {vapidKey: "BMa-Lyz6AeLZX31Ts0UdZBtTKCWqx1q73EQ_MEUJRxM7AXz31CF27BEYFaoBSlY0Koa52mkT3l10TIf9Il2eSEw"});

onMessage(messaging, (payload) => {
  const noteTitle = payload.notification.title;
  const noteOptions = {
      body: payload.notification.body,
  };
  console.log("payload: ", payload.notification.body)
  console.log("payload: ", payload.data)
  new Notification(noteTitle, noteOptions);
});
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
      .use(Toast, options)
      .use(ZiggyVue,Ziggy)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el)
  },
})
