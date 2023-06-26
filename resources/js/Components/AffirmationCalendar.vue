<template>
  <FullCalendar :options="options" class="h-full" />
</template>
<script setup>
import { reactive } from 'vue'
import '@fullcalendar/core'
import FullCalendar from '@fullcalendar/vue3'
import interactionPlugin from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid'

const response = defineProps({
  result: Object
})
const options = reactive({
  plugins: [interactionPlugin, dayGridPlugin],
  initialView: 'dayGridMonth',
  selectable: true,
  select: (arg) => {
    console.log(arg)
  },
  events: response.result
})
</script>