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
let userId = null

const app = firebase.initializeApp(firebaseConfig)
const messaging = firebase.messaging();
self.onmessage = (ev) => {
  userId = ev.data.user_id
}
messaging.onBackgroundMessage((payload) => {
  // Customize notification here
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
  };
  let noteOptions = {
    body: "You did not wrote your custom notification message. "
  }
  const user_data = JSON.parse(payload.data.user_reminders)
  const dataArray = JSON.parse(payload.data.user)
  for(let user of user_data){
    let user_original_time = user.original_time
    if(parseInt(userId) == user.user_id && user_original_time.substring(0,5) === getTimeNow()){
      noteOptions["body"] = user.custom_message
    }
  }
  if(dataArray.includes(parseInt(userId))){
    self.registration.showNotification(notificationTitle,noteOptions);
  }
  
});
// go to app when notification clicked
self.addEventListener('notificationclick', function (event)
{
    //For root applications: just change "'./'" to "'/'"
    //Very important having the last forward slash on "new URL('./', location)..."
    const rootUrl = new URL('/', location).href; 
    event.notification.close();
    event.waitUntil(
        clients.matchAll().then(matchedClients =>
        {
            for (let client of matchedClients)
            {
                if (client.url.indexOf(rootUrl) >= 0)
                {
                    return client.focus();
                }
            }

            return clients.openWindow(rootUrl).then(function (client) { client.focus(); });
        })
    );
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


