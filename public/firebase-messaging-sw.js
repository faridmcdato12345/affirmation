importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js')
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js')

var firebaseConfig = {
  apiKey: 'AIzaSyBGis6onNBKFoppXu-wPxCP5TrsNBVkZXc',
  authDomain: 'affirm-618f9.firebaseapp.com',
  projectId: 'affirm-618f9',
  storageBucket: 'affirm-618f9.appspot.com',
  messagingSenderId: '142532545526',
  appId: '1:142532545526:web:3715ccaf284865529815d7',
  measurementId: 'G-ZT5ZLC9V4W'
} 
const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
  console.log(
    '[firebase-messaging-sw.js] Received background message ',
    payload
  );
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
