var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    'build/app.css',
    'build/app.js',
    'images/icons/android-launchericon-72-72.png',
    'images/icons/android-launchericon-96-96.png',
    'images/icons/128.png',
    'images/icons/android-launchericon-144-144.png',
    'images/icons/152.png',
    'images/icons/android-launchericon-192-192.png',
    'images/icons/256.png',
    'images/icons/android-launchericon-512-512.png'
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
// Fetching content using Service Worker
self.addEventListener('fetch', (e) => {
    // Cache http and https only, skip unsupported chrome-extension:// and file://...
    if (!(
       e.request.url.startsWith('http:') || e.request.url.startsWith('https:')
    )) {
        return; 
    }

  e.respondWith((async () => {
    const r = await caches.match(e.request);
    console.log(`[Service Worker] Fetching resource: ${e.request.url}`);
    if (r) return r;
    const response = await fetch(e.request);
    const cache = await caches.open(cacheName);
    console.log(`[Service Worker] Caching new resource: ${e.request.url}`);
    cache.put(e.request, response.clone());
    return response;
  })());
});