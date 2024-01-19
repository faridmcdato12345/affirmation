<template>
  <AuthenticatedLayout>
    <Head title="Progress Calendar" />
    <div class="h-screen w-full bg-gray-900/40 backdrop-blur-sm fixed top-0"></div>
    <div class="z-20 md:-mt-14 dark:bg-gray-800 dark:border-gray-800 overflow-y-auto md:w-10/12 w-full items-start md:h-[680px] h-full bg-white rounded-md border-2 md:border-hover-theme-green">
      <div class="w-full md:pl-8 md:pr-8 md:py-16 md:h-full h-[600px] max-h-[700px] p-4">
        <AffirmationCalendar :result="response.results" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import { Head } from '@inertiajs/vue3'
import AffirmationCalendar from '../Components/AffirmationCalendar.vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'

const response = defineProps({
  results: Object
})
</script>
