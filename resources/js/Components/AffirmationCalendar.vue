<template>
  <FullCalendar :options="options" class="h-full" />
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import { reactive } from 'vue'
import '@fullcalendar/core'
import FullCalendar from '@fullcalendar/vue3'
import interactionPlugin from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid'
import listGridPlugin from '@fullcalendar/list'

const response = defineProps({
  result: Object
})
const viewPlugin = isMobile ? listGridPlugin : dayGridPlugin
const listView = isMobile ? 'listMonth' : 'dayGridMonth'
const options = reactive({
  plugins: [interactionPlugin, viewPlugin],
  initialView: listView,
  selectable: true,
  editable: false,
  select: (arg) => {
    console.log(arg)
  },
  events: response.result,
})
</script>
<style scoped>
  .fc-col-header-cell-cushion{
    color: green!important;
  }
</style>