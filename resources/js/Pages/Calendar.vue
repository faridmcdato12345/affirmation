<template>
  <AuthenticatedLayout>
    <Head title="Calendar" />
    <div class="flex md:w-10/12 w-full items-start md:h-[680px] h-full bg-white rounded-md border-2 md:border-hover-theme-green">
      <div class="w-full md:pl-16 md:pr-8 md:py-16 md:h-full h-[700px] max-h-[700px] p-4">
        <AffirmationCalendar :result="response.results" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AffirmationCalendar from '../Components/AffirmationCalendar.vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
const response = defineProps({
  results: Object
})

</script>