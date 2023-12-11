<template>
  <div class="dark:bg-gray-800 min-h-screen">
    <div class="pb-16">
      <template v-if="isMobile">
        <div class="w-full dark:shadow-gray-700/50 dark:shadow-md shadow-sm dark:bg-gray-800 bg-white py-4 px-4 flex gap-x-3 fixed top-0 left-0 z-50">
          <Link :href="route('settings')" class="mb-0 items-center flex">
            <ArrowLeftIcon class="w-5" />
          </Link>
          <h1 class="text-[20px] font-medium mb-0 dark:text-white">
            {{ routeName.routeName }}
          </h1>
          <div v-if="routeName.routeName === 'Reminder'" class="grid justify-items-end w-full">
            <div>
              <QuestionMarkCircleIcon class="w-full h-8" @click="showTutorial" />
            </div>
          </div>
        </div>
      </template>
    </div>
    <slot></slot>
  </div>
</template>
<script setup>
import { ArrowLeftIcon, QuestionMarkCircleIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'


const routeName = defineProps({
  routeName: String,
})
const emit = defineEmits(['show-tutorial'])
const showTutorial = () => {
  emit('show-tutorial')
}
</script>
