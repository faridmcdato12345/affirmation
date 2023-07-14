<template>
  <AuthenticatedLayout>
    <div class="h-screen w-full bg-gray-900/60 fixed top-0"></div>
    <Head title="Settings" />

    <div class="z-20 md:-mt-14 flex rounded-md w-full md:max-w-7xl h-full md:h-[680px] bg-white md:border-2 border-hover-theme-green">
      <div class="w-full md:w-390px md:max-w-[390px] border-r">
        <SettingsNavigation :user_type="userSub.isUserSubscribe">
          <template v-if="isMobile" #header>
            <div class="w-full shadow-sm bg-white py-4 px-4 flex gap-x-3">
              <Link href="/" class="mb-0 items-center flex">
                <ArrowLeftIcon class="w-5" />
              </Link>
              <h1 class="text-[20px] font-medium mb-0">
                App Settings
              </h1>
            </div>
          </template>
        </SettingsNavigation>
      </div>
      <div class="flex-[1]">
        <slot></slot>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import SettingsNavigation from '../Components/Setting/Navigation.vue'
import { ArrowLeftIcon } from '@heroicons/vue/24/solid'
import { isMobile } from 'mobile-device-detect'

const userSub = defineProps({
  isUserSubscribe: Object
})
</script>
