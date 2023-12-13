importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js')
precacheAndRoute(self.__WB_MANIFEST)

if (workbox) {

  // top-level routes we want to precache
  workbox.precaching.precacheAndRoute([
    '/', 
    '/login',
    '/categories',
    '/calendar',
    '/chart',
    '/settings',
    '/settings/account',
    '/comming-soon',
    '/settings/reminder',
    '/settings/feedback',
    '/settings/loginhistory',
    '/settings/subscribe',
    '/logout',
    '/register',
    '/forgot-password'
  ])

  // injected assets by Workbox CLI
  workbox.precaching.precacheAndRoute([])

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