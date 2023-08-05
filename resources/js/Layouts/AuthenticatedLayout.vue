<template>
  <div>
    <div>
      <img :src="bgImage" alt="" class="fixed top-0 left-0 w-full h-screen object-cover" />
      <div class="h-screen w-full fixed top-0 left-0 bg-gradient-to-t from-black/50 to-gray-800/70"></div>
    
      <Link href="/themes">
        <div class="cursor-pointer rounded-full flex items-center justify-center fixed right-20 top-5 md:right-24 md:top-6 bg-white/40 hover:bg-white/60 duration-150 ease-out p-3 z-40" @click.prevent="toggleDarkMode">
          <component :is="isDarkMode ? SunIcon : MoonIcon" class="w-4 h-4 md:w-6 md:h-6 text-white" />
        </div>
        <div class="cursor-pointer rounded-full flex items-center justify-center fixed right-5 top-5 md:right-10 md:top-6 bg-white/40 hover:bg-white/60 duration-150 ease-out p-3 z-40">
          <LightBulbIcon class="w-4 h-4 md:w-6 md:h-6 text-white" />
        </div>
      </Link>
      <NavigationBar v-if="checkRoute" />
    </div>
    <div class="w-full h-screen flex justify-center items-center z-20 relative">
      <slot></slot>
    </div>
  </div>
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import NavigationBar from '../Components/NavigationBar.vue'
import { useToggleDarkMode } from '../Composables/useToggleDarkMode'
import { LightBulbIcon, MoonIcon, SunIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const page = usePage()
const checkRoute = ref(true)
const bgImage = computed(() => page.props.auth.user.background_image ?? '/images/bg1.jpg')
const { isDarkMode, toggleDarkMode } = useToggleDarkMode()
const route = window.location.pathname

if(route.includes('settings') && isMobile){
  checkRoute.value = false
}
</script>
