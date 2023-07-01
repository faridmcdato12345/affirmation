<template>
  <AuthenticatedLayout>
    <Head title="Char" />
    <div class="flex md:w-10/12 w-full items-start md:h-[680px] h-full bg-white rounded-md border-2 border-hover-theme-green">
      <div class="w-full md:pl-16 md:pr-8 md:py-16 h-full px-4 py-5">
        <AffirmationChart :result="response.results" class="h-full flex flex-col justify-center items-center md:block" />
      </div>  
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import AffirmationChart from '../Components/AffirmationChart.vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

const response = defineProps({
  results: Object
})

</script>