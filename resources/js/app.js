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
const serviceWorkerDir = '/serviceworker.js'
onMessage(messaging, (payload) => {
  const noteTitle = payload.notification.title;
  const noteOptions = {
      body: payload.notification.body,
  };
  let __noteOptions = {
    body: "You did not wrote your custom notification message. "
  }
  const user_data = JSON.parse(payload.data.user_reminders)
  const dataArray = JSON.parse(payload.data.user)
  let userId = localStorage.getItem('userId')
  for(let user of user_data){
    let user_original_time = user.original_time
    if(parseInt(userId) == user.user_id && user_original_time.substring(0,5) === getTimeNow()){
      __noteOptions["body"] = user.custom_message
    }
  }
  navigator.serviceWorker.register(serviceWorkerDir)
  Notification.requestPermission(function(result){
    if(result === 'granted'){
      if(dataArray.includes(parseInt(userId))){
        navigator.serviceWorker.ready.then(function(registration) {
          registration.showNotification(noteTitle, __noteOptions);
        });
      }
    }else{console.log("not included")}
  })
});

const getTimeNow = () => {
  // Create a new Date object representing the current time
  var currentTime = new Date();

  // Get the hours, minutes, and seconds from the Date object
  var hours = currentTime.getHours();
  var minutes = currentTime.getMinutes();

  // Format the time in 24-hour format
  var formattedTime = (hours < 10 ? "0" : "") + hours + ":" + (minutes < 10 ? "0" : "") + minutes;

  return formattedTime;
}
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
