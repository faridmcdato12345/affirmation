<template>
  <AuthenticatedLayout>
    <Head title="Settings" />
    <div class="flex w-10/12 items-start h-[680px] bg-white rounded-md border-2 border-hover-theme-green">
      <SettingsNavigation />
      <slot></slot>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import SettingsNavigation from '../Components/Setting/Navigation.vue'
</script>