<template>
  <div>
    <div
      class="h-screen w-full fixed -z-[1]" style="background-image: linear-gradient(
      to bottom,
      rgba(000, 000, 000, 0.5),
      rgba(000, 000, 000, 0.5)
      ), url('/images/bg1.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    "></div>
    <Link href="/themes">
      <div class="cursor-pointer rounded-full flex items-center justify-center absolute right-10 top-6 bg-white/40 hover:bg-white/60 duration-150 ease-out p-3 z-20">
        <LightBulbIcon class="w-6 h-6 text-white" />
      </div>
    </Link>
    <NavigationBar v-if="checkRoute" />
    <div class="w-full h-screen flex justify-center items-center">
      <slot></slot>
    </div>
  </div>
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import NavigationBar from '../Components/NavigationBar.vue'
import { LightBulbIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
import {ref} from 'vue'
defineProps({
  backgroundImage: {
    type: String,
    required: true
  }
})
const checkRoute = ref(true)
const route = window.location.pathname
if(route.includes('settings') && isMobile){
  checkRoute.value = false
}
</script>
