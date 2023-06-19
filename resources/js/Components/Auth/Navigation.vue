<template>
  <div :class="[pathName != '/login' ? 'flex justify-between p-2 lg:justify-end md:justify-end' : 'flex justify-end p-2'] ">
    <div v-if="pathName != '/login'" class="cursor-pointer lg:hidden md:hidden bg-theme-green w-[25px] h-[25px] rounded-full flex items-center justify-center">
      <Link :href="route(routename)">
        <font-awesome-icon icon="fa-solid fa-angle-left" class="text-white text-xs" />
      </Link>
    </div>
    <div class="w-[25px] h-[25px] rounded-full flex items-center justify-center dark:bg-theme-green bg-hover-theme-green cursor-pointer hover:bg-theme-green dark:hover:bg-hover-theme-green" @click="toggleDark()">
      <font-awesome-icon icon="fa-solid fa-lightbulb" class="text-white text-xs dark:text-theme-green" />
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useDark, useToggle } from '@vueuse/core'
defineProps({
  routename: {
    type: String,
    default: ''
  }
})
const isDark = useDark()
const toggleDark = useToggle(isDark)
const pathName = ref()
pathName.value = window.location.pathname
</script>