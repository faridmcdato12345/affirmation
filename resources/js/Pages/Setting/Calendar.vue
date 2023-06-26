<template>
  <Settings>
    <div class="w-full pl-16 pr-8 py-16 h-full">
      <AffirmationCalendar :result="response.results" />
    </div>
  </Settings>
</template>
<script setup>
import AffirmationCalendar from '../../Components/AffirmationCalendar.vue'
import Settings from '../Settings.vue'

const response = defineProps({
  results: Object
})

</script>