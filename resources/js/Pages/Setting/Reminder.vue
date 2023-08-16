<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route_name="routeName">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <div v-if="!isMobile" class="mb-9 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green md:text-left text-center">
            Reminders
          </h1>
        </div>
        <div class="flex justify-between">
          <h3>Would you like to receive notification?</h3>
          <ToggleSwitch :notifiable="isNotify" @toggle-checkbox="updateNotifs" />
        </div>
        <div v-if="toggleSwitch.value" class="mb-6 flex justify-between">
          <div>
            <h1 class="text-theme-green font-medium">
              Personal Reminder
            </h1>
            <p>Schedule your reminder to make your affrimation fir your routine.</p>
          </div>
          <div v-if="isSubscribed.value">
            <ButtonVue label="Add" color="success" class="mt-3" @click.prevent="addTimeModal = true" />
          </div>
        </div>
        <div v-if="toggleSwitch.value" class="">
          <div class="overflow-y-auto relative h-auto md:h-auto">
            <div v-for="reminder in response.reminders" :key="reminder.id" class="flex justify-between bg-hover-theme-green md:p-4 text-white rounded items-center mb-4">
              <div>
                <p class="text-white text-base font-semibold">
                  {{ convertToAMPPM(reminder.original_time) }}
                </p>
                <p v-if="isSubscribed.value" class="text-white">
                  "{{ reminder.custom_message ? reminder.custom_message : 'You can add your custom message' }}"
                </p>
              </div>
              <div>
                <ToggleStatusSwitch :notifiable="reminder.status" :reminder="reminder" />
              </div>
              <div class="flex justify-between">
                <component :is="PencilSquareIcon" v-if="isSubscribed.value" class=" w-5 h-5 cursor-pointer  duration-200 ease-out text-blue-500" @click.stop="toggleModal('edit',reminder)" />
                <component :is="TrashIcon" class="w-5 h-5 cursor-pointer duration-200 ease-out text-rose-400" @click.stop="toggleModal('delete',reminder)" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Modal v-model="modal">
      <div class="text-center">
        <component
          :is="modalIcon ? CheckCircleIcon : XCircleIcon"
          class="w-14 mx-auto text-green-600 duration-200 ease-out" />
        <!-- <CheckCircleIcon class="w-14 mx-auto text-green-600" /> -->
        <h1 class="mt-2">
          {{ modalTextHeader }}
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          {{ modalTextBody }}
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" color="error" @click.prevent="modal = false" />
      </div>
    </Modal>
    <UpdateReminder v-model="updateTimeModal" :reminder="selectedReminder" />
    <AddReminderModal v-model="addTimeModal" :is-subscribed="isSubscribed" />
    <DeleteReminderModal v-model="deleteTimeModal" :reminder="selectedReminder" />
  </component>
</template>
<script setup>
import ToggleStatusSwitch from '../../Components/ToggleStatusSwitch.vue'
import UpdateReminder from '../../Components/Reminder/UpdateReminder.vue'
import AddReminderModal from '../../Components/Reminder/AddReminder.vue'
import DeleteReminderModal from '../../Components/Reminder/DeleteReminder.vue'
import { initializeApp } from '@firebase/app'
import { getMessaging, getToken } from '@firebase/messaging'
import ToggleSwitch from '../../Components/ToggleSwitch.vue'
import AuthenticateMobileSettingLayout from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { isMobile } from 'mobile-device-detect'
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/solid'
import Settings from '../Settings.vue'
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid'
import Button from '../../Components/Auth/Button.vue'
import ButtonVue from '../../Components/Button.vue'
import { ref,reactive } from 'vue'
import Modal from '../../Components/Modal.vue'
import {  router } from '@inertiajs/vue3'


const routeName = ref('Reminder')
const modal = ref(false)
const modalTextBody = ref('')
const addTimeModal = ref(false)
const updateTimeModal = ref(false)
const deleteTimeModal = ref(false)
const modalTextHeader = ref('')
const modalIcon = ref(true)
const selectedReminder = ref({})
const isSubscribed = reactive({
  value: localStorage.getItem('isSubcribe') === 'true' ? true : false
})
const isNotify = ref(0)
const response = defineProps({
  reminders: Object
})

isSubscribed.value = localStorage.getItem('isSubcribe')
isNotify.value = localStorage.getItem('isNotify')



const toggleSwitch = reactive({
  value: isNotify.value == 1 ? true : false
})
const updateNotifs = (data) => {

  toggleSwitch.value = data
  if(data){
    const firebaseConfig = {
      apiKey: 'AIzaSyCDL5jn4IThej6gpOILzj8XmrzOFMRn0H0',
      authDomain: 'affirm-7b375.firebaseapp.com',
      projectId: 'affirm-7b375',
      storageBucket: 'affirm-7b375.appspot.com',
      messagingSenderId: '629732409638',
      appId: '1:629732409638:web:48727d1382c07824e941e7',
      measurementId: 'G-G2NDWXEH44'
    }
    
    const app = initializeApp(firebaseConfig)
    
    const messaging = getMessaging(app)
    console.log('initializedeAPp')
    if(Notification.permission !== 'denied'){
      console.log('Notification.permission: ',Notification.permission)
      Notification.requestPermission().then((permission) => {
      // If the user accepts, let's create a notification
        if (permission === 'granted') {
          getToken(messaging, {vapidKey: 'BBAUnekRlG_a9NYANo55GflZVJmmx1MmqERD6rfn1Ka_OUxOqjOizxQ1x568qRi81w-flcnnv1Q0sS3TkqGVyDA'}).then(result => {
            const token = reactive({
              fcm_token: result,
              isNotify: true,
            })
            router.post(route('fcmToken'), token)
            console.log('wtf')
            localStorage.setItem('isNotify',1)
          })
        }
      })
    }
  }else{
    const token = reactive({
      isNotify: false,
    })
    router.post(route('fcmToken'), token)
    localStorage.setItem('isNotify',0)
  }
  
}

const toggleModal = (type,reminder) => {
  selectedReminder.value = reminder
  type === 'delete' ? deleteTimeModal.value = true : updateTimeModal.value = true
}

const convertToAMPPM = (time) => {
  const [hours, minutes] = time.split(':')
  const date = new Date(0, 0, 0, hours, minutes)
  return date.toLocaleString('en-US', {
    hour: 'numeric',
    minute: 'numeric',
    hour12: true,
  })
}

</script>
