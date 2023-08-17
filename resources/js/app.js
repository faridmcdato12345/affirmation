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
  apiKey: 'AIzaSyCDL5jn4IThej6gpOILzj8XmrzOFMRn0H0',
  authDomain: 'affirm-7b375.firebaseapp.com',
  projectId: 'affirm-7b375',
  storageBucket: 'affirm-7b375.appspot.com',
  messagingSenderId: '629732409638',
  appId: '1:629732409638:web:48727d1382c07824e941e7',
  measurementId: 'G-G2NDWXEH44'
}

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const messaging = getMessaging(app);

//const token = getToken(messaging, {vapidKey: "BMa-Lyz6AeLZX31Ts0UdZBtTKCWqx1q73EQ_MEUJRxM7AXz31CF27BEYFaoBSlY0Koa52mkT3l10TIf9Il2eSEw"});
let isMobile = {
  Android: function() {return navigator.userAgent.match(/Android/i);},
  iOS: function() {return navigator.userAgent.match(/iPhone|iPad|iPod/i);},
  any: function() {return (isMobile.Android() || isMobile.iOS());}
};
const _os = navigator.userAgent
console.log("_os: ", _os)
onMessage(messaging, (payload) => {
  const noteTitle = payload.notification.title;
  const noteOptions = {
      body: payload.notification.body,
  };
  console.log("payload: ", payload.notification.body)
  console.log("payload: ", payload.data)
  if(isMobile.Android() || isMobile.iOS()){
    self.registration.showNotification(noteTitle, noteOptions)
  }else{
    new Notification(noteTitle, noteOptions);
  }
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
