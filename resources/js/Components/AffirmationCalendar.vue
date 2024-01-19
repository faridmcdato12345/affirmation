<template>
  <div class="h-full">
    <FullCalendar :options="options" class="h-full" />
    <Modal v-model="modal" max-width="default">
      <div class="absolute top-4 right-4 cursor-pointer" @click.prevent="modal = false">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </div>
      <div class="text-left dark:bg-gray-800 p-2">
        <p class="dark:text-gray-400">
          {{ modalAffirmDate }}
        </p>
        <p class="text-gray-500 text-base dark:text-gray-300 mt-4">
          Affirmation 
        </p> 
        <h2 class="text-3xl dark:text-white">
          {{ modalAffirmTitle }}
        </h2>
        <div class="flex justify-between mt-4">
          <p class="text-gray-800 dark:text-gray-100 font-medium">
            Happiness Rating:
          </p>
          <p class="text-gray-800 dark:text-gray-100">
            {{ modalAffirmHappiness }} / 5
          </p>
        </div>
        <div class="flex justify-between">
          <p class="text-gray-800 dark:text-gray-100 font-medium">
            Affirm Relatedness:
          </p>
          <p class="text-gray-800 dark:text-gray-100">
            {{ modalAffirmBelief }} / 5
          </p>
        </div>
        <h3 class="text-base text-gray-800 dark:text-gray-100 mt-4">
          Life Related Inputs
        </h3>
        <p class="leading-5 text-gray-800 dark:text-gray-100">
          1. {{ modalAffirmInputOne }}
        </p>
        <p class="leading-5 text-gray-800 dark:text-gray-100 mt-2">
          2. {{ modalAffirmInputTwo }}
        </p>
        <p class="leading-5 text-gray-800 dark:text-gray-100 mt-2">
          3. {{ modalAffirmInputThree }}
        </p>
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
const dateFormatter = new Intl.DateTimeFormat('en-us', { dateStyle: 'full' })
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
  eventClick: function(info) {
    modal.value = true
    modalAffirmTitle.value = JSON.stringify(info.event.title)
    modalAffirmDate.value = dateFormatter.format(info.event.start)
    modalAffirmHappiness.value = JSON.stringify(info.event.extendedProps.happiness)
    modalAffirmBelief.value = JSON.stringify(info.event.extendedProps.belief)
    modalAffirmInputOne.value = info.event.extendedProps.input_1
    modalAffirmInputTwo.value = info.event.extendedProps.input_2
    modalAffirmInputThree.value = info.event.extendedProps.input_3
  }
})

onMounted(() => {
  let xx = document.querySelector('.fc-toolbar-title')
  xx.classList.add('dark:text-gray-200')
})
</script>