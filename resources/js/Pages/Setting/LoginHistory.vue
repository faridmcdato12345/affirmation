<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayoutVue : Settings">
    <div class="md:w-full md:pl-12 md:pr-8 md:py-16 h-full">
      <div class="mb-9 border-b-2 border-hover-theme-green pb-5">
        <h1 class="text-theme-green md:text-left text-center">
          Login History
        </h1>
        <p>Shown below are your records of your login history for this month</p>
      </div>
      <div>
        <ul>
          <li v-for="login in data" :key="login.id" class="py-2 border-b">
            <div class="flex">
              <div>
                <p>{{ login.user_agent }}</p>
                <p>{{ login.created_at }}</p>
              </div>
            </div>
          </li>
        </ul>
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
