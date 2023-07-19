<template>
  <div class="h-full">
    <FullCalendar :options="options" class="h-full" />
    <Modal v-model="modal">
      <div class="text-left">
        <table>
          <tr>
            <td><span class="font-semibold">Title: </span></td>
            <td>{{ modalAffirmTitle }}</td>
          </tr>
          <tr>
            <td><span class="font-semibold">Date: </span></td>
            <td>{{ modalAffirmDate }}</td>
          </tr>
          <tr>
            <td><span class="font-semibold">Happiness Score: </span></td>
            <td>{{ modalAffirmHappiness }}</td>
          </tr>
          <tr>
            <td><span class="font-semibold">Belief Score: </span></td>
            <td>{{ modalAffirmBelief }}</td>
          </tr>
          <tr>
            <td><span class="font-semibold">First Experience: </span></td>
            <td>{{ modalAffirmInputOne }}</td>
          </tr>
          <tr>
            <td><span class="font-semibold">Second Experience: </span></td>
            <td>{{ modalAffirmInputTwo }}</td>
          </tr>
          <tr>
            <td><span class="font-semibold">Third Experience: </span></td>
            <td>{{ modalAffirmInputThree }}</td>
          </tr>
        </table>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Close" color="error" @click.prevent="modal = false" />
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import { reactive,ref } from 'vue'
import '@fullcalendar/core'
import FullCalendar from '@fullcalendar/vue3'
import interactionPlugin from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid'
import listGridPlugin from '@fullcalendar/list'
import Modal from '../Components/Modal.vue'

const response = defineProps({
  result: Object
})
const viewPlugin = isMobile ? listGridPlugin : dayGridPlugin
const listView = isMobile ? 'listMonth' : 'dayGridMonth'
const modal = ref(false)
const modalAffirmTitle = ref('')
const modalAffirmDate = ref('')
const modalAffirmHappiness = ref('')
const modalAffirmBelief = ref('')
const modalAffirmInputOne = ref('')
const modalAffirmInputTwo = ref('')
const modalAffirmInputThree = ref('')
const dateFormatter = new Intl.DateTimeFormat('en-us',{
  dateStyle: 'full'
})
const options = reactive({
  plugins: [interactionPlugin, viewPlugin],
  initialView: listView,
  selectable: true,
  editable: false,
  select: (arg) => {
    console.log(arg)
  },
  events: response.result,
  eventClick: function(info){
    modal.value = true,
    modalAffirmTitle.value = JSON.stringify(info.event.title),
    modalAffirmDate.value = dateFormatter.format(info.event.start),
    modalAffirmHappiness.value = JSON.stringify(info.event.extendedProps.happiness),
    modalAffirmBelief.value = JSON.stringify(info.event.extendedProps.belief),
    modalAffirmInputOne.value = JSON.stringify(info.event.extendedProps.input_1),
    modalAffirmInputTwo.value = JSON.stringify(info.event.extendedProps.input_2),
    modalAffirmInputThree.value = JSON.stringify(info.event.extendedProps.input_3)
  }
})
</script>