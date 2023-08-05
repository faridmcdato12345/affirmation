<template>
  <div class="w-full h-full p-4">
    <div class="mb-10">
      <Link :href="route('settings')">
        <component 
          :is="ArrowLeftCircleIcon" 
          class="text-hover-theme-green duration-200 ease-out flex items-start justify-start w-10" />
      </Link>
    </div>
    <slot></slot>
  </div>
</template>
<script setup>
import { ArrowLeftCircleIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
</script>
