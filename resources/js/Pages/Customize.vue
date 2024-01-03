<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <div v-if="!isMobile" class="mb-5 border-b-2 border-hover-theme-green pb-4">
          <h1 class="dark:text-white text-theme-green text-center md:text-left font-semibold">
            Customization
          </h1>
        </div>
        <div class="mb-8 flex justify-between">
          <div>
            <h1 class="dark:text-white text-theme-green font-medium mb-0">
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
            <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[10px] sm:after:top-[10px] after:left-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          </label>
        </div>
        <hr class="my-6" />
        <div class="mb-8 flex justify-between items-center">
          <div>
            <h1 class="dark:text-white text-theme-green font-medium mb-0">
              Background Theme
            </h1>
            <p class="dark:text-gray-400">
              Change your background to your preference
            </p>
          </div>
          <Button label="Themes" color="success" component-type="link" href="/themes" />
        </div>
      </div>
    </div>
  </component>
</template>
<script setup>

import { ref } from 'vue'
import { isMobile } from 'mobile-device-detect'
import Settings from '../Pages/Settings.vue'
import AuthenticateMobileSettingLayout from '../Layouts/AuthenticateMobileSettingLayout.vue'
import { useToggleDarkMode } from '../Composables/useToggleDarkMode'
import Button from '../Components/Button.vue'

const { isDarkMode, toggleDarkMode } = useToggleDarkMode()

const routeName = ref('Customization')
</script>
