<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayoutVue : Settings" route-name="Login History">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-12 md:pr-8 md:py-16 h-full">
        <div class="mb-5 border-b border-gray-400 dark:border-gray-700 pb-3">
          <h1 class="dark:text-white text-theme-green">
            Login History
          </h1>
          <p class="dark:text-gray-300">
            Shown below are your records of your login history for this month
          </p>
        </div>
        <div class="">
          <ul class="overflow-y-auto relative h-full md:h-[480px]">
            <li v-for="login in data" :key="login.id" class="pb-5 pt-3 border-b dark:border-gray-700">
              <div class="flex">
                <div>
                  <p class="text-gray-700 dark:text-gray-300 font-medium">
                    {{ login.created_at }}
                  </p>
                  <p class="dark:text-gray-300">
                    {{ login.user_agent }}
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>    
  </component>
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import AuthenticateMobileSettingLayoutVue from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import Settings from '../Settings.vue'

defineProps({
  data: {
    type: Object,
    default: () => {}
  }
})
</script>
