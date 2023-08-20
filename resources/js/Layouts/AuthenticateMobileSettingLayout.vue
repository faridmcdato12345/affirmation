<template>
  <div class="">
    <div class="mb-10">
      <template v-if="isMobile">
        <div class="w-full shadow-sm bg-white py-4 px-4 flex gap-x-3">
          <Link :href="route('settings')" class="mb-0 items-center flex">
            <ArrowLeftIcon class="w-5" />
          </Link>
          <h1 class="text-[20px] font-medium mb-0">
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
