importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js')


if (workbox) {
  // injected assets by Workbox CLI
  workbox.precaching.precacheAndRoute(self.__WB_MANIFEST || [])

  // match routes for homepage, blog and any sub-pages of blog
  workbox.routing.registerRoute(
    /^\/(?:(settings)?(\/.*)?)$/,
    new workbox.strategies.NetworkFirst({
      cacheName: 'static-resources',
    })
  )

  // js/css files
  workbox.routing.registerRoute(
    /\.(?:js|css)$/,
    new workbox.strategies.NetworkFirst({
      cacheName: 'static-resources',
    })
  )

  // images
  workbox.routing.registerRoute(
    // Cache image files.
    /\.(?:png|jpg|jpeg|svg|gif)$/,
    // Use the cache if it's available.
    new workbox.strategies.CacheFirst({
      // Use a custom cache name.
      cacheName: 'image-cache',
      plugins: [
        new workbox.expiration.Plugin({
          // Cache upto 50 images.
          maxEntries: 50,
          // Cache for a maximum of a week.
          maxAgeSeconds: 7 * 24 * 60 * 60,
        })
      ],
    })
  )
}
self.addEventListener('install', () => self.skipWaiting())
self.addEventListener('push', (event) => {
  let notification = event.data.json()
  
  event.waitUntil(self.registration.showNotification(notification.title, {
    body: notification.body,
    icon: 'images/icons/128.png',
    data: {
      notifURL: notification.url
    }
  }))

})
self.addEventListener('notificationclick', (event) => {
  event.waitUntil(clients.openWindow(event.notification.data.notifURL))
})