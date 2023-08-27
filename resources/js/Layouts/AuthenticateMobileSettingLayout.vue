<template>
  <div class="dark:bg-gray-800 min-h-screen">
    <div class="mb-1">
      <template v-if="isMobile">
        <div class="w-full dark:shadow-gray-700/50 dark:shadow-md shadow-sm dark:bg-gray-800 bg-white py-4 px-4 flex gap-x-3">
          <Link :href="route('settings')" class="mb-0 items-center flex">
            <ArrowLeftIcon class="w-5" />
          </Link>
          <h1 class="text-[20px] font-medium mb-0 dark:text-white">
            {{ routeName.routeName }}
          </h1>
        </div>
      </template>
    </div>
    <slot></slot>
  </div>
</template>
<script setup>
import { ArrowLeftIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'

const routeName = defineProps({
  routeName: String,
})
</script>
