import { ref } from 'vue'
export function useHomeInstallation(){
  //Global Variables
  const isPWA = ref(true)  // Enables or disables the service worker and PWA
  const isAJAX = ref(false) // AJAX transitions. Requires local server or server
  const pwaName = ref('Affirm') //Local Storage Names for PWA
  const pwaRemind = ref(1) //Days to re-remind to add to home
  const pwaNoCache = ref(false) //Requires server and HTTPS/SSL. Will clear cache with each visit

  //Setting Service Worker Locations scope = folder | location = service worker js location
  const pwaScope = ref('.')
  const pwaLocation = ref('/serviceworker.js')
  // const isMobile = reactive({
  //   Android: function() {return navigator.userAgent.match(/Android/i)},
  //   iOS: function() {return navigator.userAgent.match(/iPhone|iPad|iPod/i)},
  //   any: function() {return (isMobile.Android() || isMobile.iOS())}
  // })
  const mobileOs = ref(navigator.userAgent)
  const getInitTemplate = async () => {
    if(isPWA.value){
      let checkPWA = document.getElementsByTagName('html')[0]
      if(!checkPWA.classList.contains('isPWA')){
        window.addEventListener('load', function() {
          navigator.serviceWorker.register(pwaLocation, {scope: pwaScope}).then(function(registration){registration.update()})
          console.log('Service Worker successfully registered')
        })
      }
    }
  }
    
  return { 
    isPWA, 
    isAJAX, 
    pwaName, 
    pwaRemind,
    pwaNoCache,
    pwaScope,
    pwaLocation,
    getInitTemplate,
    mobileOs
  }
}