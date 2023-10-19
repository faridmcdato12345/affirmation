<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName">
    <Head title="Coming Soon" />
    <div class="flex justify-center items-center h-screen dark:bg-gray-800 bg-white ">
      <h1 class="dark:text-white text-[20px] font-medium">
        Coming Soon!
      </h1>
    </div>
  </component>
</template>
<script setup>

import { ref } from 'vue'
import { isMobile } from 'mobile-device-detect'
import Settings from '../Pages/Settings.vue'
import AuthenticateMobileSettingLayout from '../Layouts/AuthenticateMobileSettingLayout.vue'

const routeName = ref('Reminder')
</script>
