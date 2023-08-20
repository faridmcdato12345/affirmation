importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js')
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js')

var firebaseConfig = {
  apiKey: 'AIzaSyCDL5jn4IThej6gpOILzj8XmrzOFMRn0H0',
  authDomain: 'affirm-7b375.firebaseapp.com',
  projectId: 'affirm-7b375',
  storageBucket: 'affirm-7b375.appspot.com',
  messagingSenderId: '629732409638',
  appId: '1:629732409638:web:48727d1382c07824e941e7',
  measurementId: 'G-G2NDWXEH44'
} 


const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
  // Customize notification here
  const notificationTitle = 'Affirm';
  const notificationOptions = {
    body: 'Background Message body.',
  };
  self.registration.showNotification(notificationTitle, notificationOptions);
});
