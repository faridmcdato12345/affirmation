<template>
  <div class="h-full">
    <FullCalendar :options="options" class="h-full" />
    <Modal v-model="modal" class="w-11/12">
      <div class="text-left dark:bg-gray-800">
        <table>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">Affirmation: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmTitle }}
            </td>
          </tr>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">Date: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmDate }}
            </td>
          </tr>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">Happiness Score: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmHappiness }}
            </td>
          </tr>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">Belief Score: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmBelief }}
            </td>
          </tr>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">First Experience: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmInputOne }}
            </td>
          </tr>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">Second Experience: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmInputTwo }}
            </td>
          </tr>
          <tr>
            <td><span class="font-semibold dark:text-gray-200">Third Experience: </span></td>
            <td class="dark:text-gray-200">
              {{ modalAffirmInputThree }}
            </td>
          </tr>
        </table>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Close" color="gray" btn-block @click.prevent="modal = false" />
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import { reactive, ref,onMounted  } from 'vue'
import '@fullcalendar/core'
import FullCalendar from '@fullcalendar/vue3'
import interactionPlugin from '@fullcalendar/interaction'
import dayGridPlugin from '@fullcalendar/daygrid'
import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'

const response = defineProps({
  result: Object
})

const viewPlugin = isMobile ? dayGridPlugin : dayGridPlugin
const listView = isMobile ? 'dayGridMonth' : 'dayGridMonth'
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
  headerToolbar: {
    start: 'title',
    center: '',
    end: 'today,prev,next'
  },
  initialView: listView,
  selectable: true,
  editable: false,
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
onMounted(() => {
  let xx = document.querySelector('.fc-toolbar-title')
  xx.classList.add('dark:text-gray-200')
})
//document.getElementsByClassName('fc-toolbar-title').addClass('dark:text-gray-200')



</script>
<style>

</style>