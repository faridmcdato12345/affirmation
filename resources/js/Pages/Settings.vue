<template>
  <AuthenticatedLayout>
    <div class="h-screen w-full bg-gray-900/60 fixed top-0"></div>
    <Head title="Settings" />

    <div class="z-20 md:-mt-14 flex rounded-md w-full md:max-w-7xl h-full md:h-[680px] bg-white border-2 border-hover-theme-green">
      <div class="w-full md:w-390px md:max-w-[390px] border-r">
        <SettingsNavigation />
      </div>
      <div class="flex-[1]">
        <slot></slot>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import SettingsNavigation from '../Components/Setting/Navigation.vue'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
console.log('User: ', user)
</script>
