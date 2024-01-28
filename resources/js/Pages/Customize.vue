<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <div v-if="!isMobile" class="mb-7 border-b border-gray-700 pb-2">
          <h1 class="dark:text-white text-theme-green text-center md:text-left font-semibold">
            Preference
          </h1>
        </div>
        <div class="mb-4 flex justify-between">
          <div>
            <h1 class="dark:text-white text-lg text-theme-green font-medium mb-0">
              Dark Mode
            </h1>
            <p class="dark:text-gray-400">
              Protect your eyes and enable dark mode
            </p>
          </div>
          <label class="relative inline-flex items-center mb-4 cursor-pointer">
            <input 
              type="checkbox" 
              class="sr-only peer" 
              :checked="isDarkMode"
              @click="toggleDarkMode" />
            <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[9px] sm:after:top-[9px] after:left-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          </label>
        </div>
        <div class="flex justify-between items-center border-t dark:border-gray-700 py-5">
          <div>
            <h1 class="dark:text-white text-lg text-theme-green font-medium mb-0">
              News Letter
            </h1>
            <p class="dark:text-gray-400 max-w-[38ch] md:max-w-[70ch] leading-5">
              Join our newsletter and get exclusive updates every week!
            </p>
          </div>
          <label class="relative inline-flex items-center mb-4 cursor-pointer">
            <input 
              type="checkbox" 
              class="sr-only peer" 
              :checked="newsLetterSubscription"
              @click="updateNewsLetterSub" />
            <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] sm:after:top-[2px] after:left-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          </label>
        </div> 
        <div class="flex justify-between items-center border-t dark:border-gray-700 py-5">
          <div>
            <h1 class="dark:text-white text-lg text-theme-green font-medium mb-0">
              App Notifications
            </h1>
            <p class="dark:text-gray-400">
              Subscribe to app notifications to receive important updates about the affirm app 
            </p>
          </div>
          <label class="relative inline-flex items-center mb-4 cursor-pointer">
            <input 
              type="checkbox" 
              class="sr-only peer" 
              :checked="appNotifSubscription"
              @click="updateAppNotifSub" />
            <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] sm:after:top-[2px] after:left-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          </label>
        </div> 
        <div class="flex justify-between items-center border-t dark:border-gray-700 py-5">
          <div>
            <h1 class="dark:text-white text-lg text-theme-green font-medium mb-0">
              Background Theme
            </h1>
            <p class="dark:text-gray-400">
              Change your background to your preference
            </p>
          </div>
          <Button label="Themes" color="success" component-type="link" href="/themes" />
        </div>
        <div class="flex justify-between items-center border-t dark:border-gray-700 py-5">
          <div>
            <h1 class="dark:text-white text-lg text-theme-green font-medium mb-0">
              Intro Tutorial
            </h1>
            <p class="dark:text-gray-400">
              Walkthrough on how the application works
            </p>
          </div>
          <Button label="Show Intro" color="success" @click.prevent="enableIntro" />
        </div> 
      </div>
    </div>
  </component>
</template>
<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'
import Settings from '../Pages/Settings.vue'
import AuthenticateMobileSettingLayout from '../Layouts/AuthenticateMobileSettingLayout.vue'
import { useToggleDarkMode } from '../Composables/useToggleDarkMode'
import Button from '../Components/Button.vue'
import { toast } from '../Composables/useToast'

defineProps({
  newsLetterSubscription: Boolean,
  appNotifSubscription: Boolean,
})

const { isDarkMode, toggleDarkMode } = useToggleDarkMode()

const routeName = ref('Customization')

const enableIntro = async () => {
  router.patch(route('intro.show'), {} ,{
    onSuccess: () => {
      router.get(route('home'))
    }
  })
}

const updateNewsLetterSub = () => {
  router.patch(route('subscription.newsletter', {}, {
    onSuccess: () => {
      toast.error('Subscription for newsletter has been updated.')
    },
    onError: () => {
      toast.error('Can\'t update subscription setting. Please try again.')
    }
  }))
}

const updateAppNotifSub = () => {
  router.patch(route('subscription.appnotif', {}, {
    onSuccess: () => {
      toast.error('Subscription for app notif has been updated.')
    },
    onError: () => {
      toast.error('Can\'t update subscription setting. Please try again.')
    }
  }))
}
</script>
