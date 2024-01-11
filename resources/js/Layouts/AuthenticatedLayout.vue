<template>
  <div>
    <div>
      <img :src="bgImage" alt="" class="fixed top-0 left-0 w-full h-screen object-cover" />
      <div class="h-screen w-full fixed top-0 left-0 bg-gradient-to-t from-black/50 to-gray-800/70"></div>
      <NavigationBar v-if="checkRoute" />
    </div>
    <div class="w-full h-screen flex justify-center items-center z-20 relative">
      <slot></slot>
    </div>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'
import NavigationBar from '../Components/NavigationBar.vue'
import { useToggleDarkMode } from '../Composables/useToggleDarkMode'

const page = usePage()
const checkRoute = ref(true)
useToggleDarkMode()

const bgImage = computed(() => page.props.auth.user.background_image ?? '/images/bg1.jpg')
const route = window.location.pathname

if(route.includes('settings') && isMobile){
  checkRoute.value = false
}
</script>
