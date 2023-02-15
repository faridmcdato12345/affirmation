var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    'offline',
    'build/app.css',
    'build/app.js',
    'images/icons/android-launchericon-72-72.png',
    'images/icons/android-launchericon-96-96.png',
    'images/icons/128.png',
    'images/icons/android-launchericon-144-144.png',
    'images/icons/152.png',
    'images/icons/android-launchericon-192-192.png',
    'images/icons/256.png',
    'images/icons/android-launchericon-512-512.png',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
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
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});