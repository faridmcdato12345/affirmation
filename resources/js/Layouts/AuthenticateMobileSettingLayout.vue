<template>
  <div class="dark:bg-gray-800 min-h-screen">
    <img :src="bgImage" alt="" class="fixed top-0 left-0 w-full h-screen object-cover z-0" />
    <div class="h-screen w-full fixed top-0 left-0 dark:bg-gray-800/90 backdrop-blur-md to-gray-800 z-0"></div>
    <div class="pb-16 z-50">
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
    <div class="z-50 relative">
      <slot></slot>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import { ArrowLeftIcon, QuestionMarkCircleIcon } from '@heroicons/vue/24/solid'
import { Link, usePage } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'

const routeName = defineProps({
  routeName: String,
})

const page = usePage()
const emit = defineEmits(['show-tutorial'])

const bgImage = computed(() => page.props.auth.user.background_image ?? '/images/bg1.jpg')

const showTutorial = () => {
  emit('show-tutorial')
}
</script>
