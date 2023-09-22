var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    'build/app.css',
    'build/app.js',
    'build/Reminder.css',
    'build/Index.css',
    'images/icons/android-launchericon-72-72.png',
    'images/icons/android-launchericon-96-96.png',
    'images/icons/128.png',
    'images/icons/android-launchericon-144-144.png',
    'images/icons/152.png',
    'images/icons/android-launchericon-192-192.png',
    'images/icons/256.png',
    'images/icons/android-launchericon-512-512.png',
    'images/tutorial/mobile-edit-tutorial.gif'
];
// Cache on install
self.addEventListener("install", event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});
// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => {
                        caches.delete(cacheName)
                    })
            );
        })
    );
});
// Listen for the 'activate' event.
// self.addEventListener('activate', (event) => {
//     // Clean up old caches if necessary.
//     event.waitUntil(
//         caches.keys().then((cacheNames) => {
//         return Promise.all(
//             cacheNames.map((name) => {
//             if (name !== staticCacheName) {
//                 return caches.delete(name);
//             }
//             })
//         );
//         })
//     );
// });
// Listen for the 'fetch' event.
self.addEventListener('fetch', (event) => {
    event.respondWith(
        // Try to fetch the resource from the cache.
        caches.match(event.request).then((response) => {
            // If found in cache, return the cached response.
            if (response) {
                return response;
            }

            // If not found in cache, fetch the resource from the network.
            return fetch(event.request).then((networkResponse) => {
                console.log('netwokResponse: ', networkResponse)
                // Clone the response to store it in the cache.
                const responseToCache = networkResponse.clone();

                // Open the cache and store the response for future use.
                caches.open(staticCacheName).then((cache) => {
                cache.put(event.request, responseToCache);
                });

                // Return the network response to the page.
                return response;
            });
        })
    );
});
// Listen for a message from the main application.
self.addEventListener('message', (event) => {
    if (event.data === 'skipWaiting') {
        // Trigger the service worker to skip waiting and activate the new one.
        self.skipWaiting();
    }
});
// go to app when notification clicked
self.addEventListener('notificationclick', function (event)
{
    //For root applications: just change "'./'" to "'/'"
    //Very important having the last forward slash on "new URL('./', location)..."
    const rootUrl = new URL('./', location).href; 
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

