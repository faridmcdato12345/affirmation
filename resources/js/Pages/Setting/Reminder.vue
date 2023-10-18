<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName" :is-button-header="true" @show-tutorial="tutorial = true">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <div v-if="!isMobile" class="mb-9 border-b-2 border-hover-theme-green pb-5" :class="isMobile ?? 'flex justify-between'">
          <h1 class="dark:text-white text-theme-green md:text-left text-center">
            Reminders
          </h1>
        </div>
        <div class="flex justify-between">
          <component :is="isMobile ? 'h5' : 'h1'" class="dark:text-white text-theme-green md:text-left font-medium">
            Receive notification
          </component>
          <ToggleSwitch :notifiable="isNotify" @toggle-checkbox="updateNotifs" />
        </div>
        <p class="dark:text-gray-300">
          Enable to start receiving notifications
        </p>
        <div v-if="toggleSwitch.value" :class="!isMobile ? 'mb-6 flex justify-between' : 'mb-2'">
          <div class="mt-7">
            <h1 class="dark:text-white text-theme-green font-medium">
              Personal Reminder
            </h1>
            <p class="dark:text-gray-300">
              Schedule your reminder to make your affirmation fit your routine.
            </p>
          </div>
          <div v-if="isSubscribed.value" :class="isMobile ? 'flex justify-end' : ''">
            <component :is="PlusCircleIcon" class="mt-7 w-8 h-8 text-theme-green cursor-pointer hover:text-theme-green/70 transition-all dark:text-green-600 dark:hover:text-green-700" @click.prevent="addTimeModal = true" />
          </div>
        </div>
        <div v-if="toggleSwitch.value" class="">
          <div class="overflow-y-auto relative h-auto md:h-auto">
            <div 
              v-for="reminder in response.reminders" 
              :key="reminder.id" 
              class="flex justify-between bg-green-800 p-4 text-white rounded items-center mb-4"
              @click="isMobile ? toggleModal('edit', reminder): ''">
              <div :class="!isMobile ? 'w-60' : ''">
                <p class="text-white text-base font-semibold">
                  {{ convertToAMPPM(reminder.original_time) }}
                </p>
                <p v-if="isSubscribed.value" class="text-white">
                  "{{ reminder.custom_message ? reminder.custom_message : 'You can add your custom message' }}"
                </p>
              </div>
              <div :class="!isMobile ? 'w-52' : ''" @click.stop="toggleData(reminder.status)">
                <ToggleStatusSwitch :notifiable="reminder.status" :reminder="reminder" />
              </div>
              <div v-if="!isMobile" class="flex justify-between gap-x-2">
                <component 
                  :is="PencilSquareIcon" 
                  v-if="isSubscribed.value" 
                  class="w-6 h-6 cursor-pointer  duration-200 ease-out " 
                  @click.stop="toggleModal('edit',reminder)" />
                <component 
                  :is="TrashIcon" 
                  class="w-6 h-6 cursor-pointer duration-200 ease-out" 
                  @click.stop="toggleModal('delete',reminder)" />
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
    <Modal v-model="tutorial">
      <h1 class="mt-2 dark:text-white ">
        How to Edit or Delete reminder?
      </h1>
      <p class="text-md max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-300">
        To edit or delete a reminder please click the reminder time and a pop box will appear.
      </p>
      <MobileEditTutorial class="mt-4" />
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Got It!" color="success" @click.prevent="tutorial = false" />
      </div>
    </Modal>
    <UpdateReminder v-model="updateTimeModal" :reminder="selectedReminder" />
    <AddReminderModal v-model="addTimeModal" :is-subscribed="isSubscribed" />
    <DeleteReminderModal v-model="deleteTimeModal" :reminder="selectedReminder" />
  </component>
</template>
<script setup>
import MobileEditTutorial from '../../Components/MobileEditTutorial.vue'
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
import { PencilSquareIcon, TrashIcon, PlusCircleIcon } from '@heroicons/vue/24/solid'
import Button from '../../Components/Auth/Button.vue'
import { ref,reactive } from 'vue'
import Modal from '../../Components/Modal.vue'
import {  router } from '@inertiajs/vue3'


const routeName = ref('Reminder')
const modal = ref(false)
const tutorial = ref(false)
const modalTextBody = ref('')
const statusData = ref('')
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

const permissionStatus = ref(false)

const toggleSwitch = reactive({
  value: isNotify.value == 1 ? true : false
})
const updateNotifs = (data) => {
  console.log('emited value: ', data)
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
    if(Notification.permission !== 'denied'){
      console.log('initial permissionStatus: ',permissionStatus.value) // true
      if(!permissionStatus.value){
        Notification.requestPermission().then((permission) => {
          // If the user accepts, let's create a notification
          if (permission === 'granted') {
            getToken(messaging, {
              vapidKey: 'BBAUnekRlG_a9NYANo55GflZVJmmx1MmqERD6rfn1Ka_OUxOqjOizxQ1x568qRi81w-flcnnv1Q0sS3TkqGVyDA'
            }).then(result => {
              const token = reactive({
                fcm_token: result,
                isNotify: true,
              })
              router.post(route('fcmToken'), token)
              localStorage.setItem('isNotify',1)
            })
          }
        }).catch((error) => console.log('error request permission: ', error))
        permissionStatus.value = true
        console.log('permissionStatus: ', permissionStatus.value)
      }else{
        getToken(messaging, {
          vapidKey: 'BBAUnekRlG_a9NYANo55GflZVJmmx1MmqERD6rfn1Ka_OUxOqjOizxQ1x568qRi81w-flcnnv1Q0sS3TkqGVyDA'
        }).then(result => {
          const token = reactive({
            fcm_token: result,
            isNotify: true,
          })
          router.post(route('fcmToken'), token)
          localStorage.setItem('isNotify',1)
        })
      }
    }else if(Notification.permission === 'granted'){
      getToken(messaging, {
        vapidKey: 'BBAUnekRlG_a9NYANo55GflZVJmmx1MmqERD6rfn1Ka_OUxOqjOizxQ1x568qRi81w-flcnnv1Q0sS3TkqGVyDA'
      }).then(result => {
        const token = reactive({
          fcm_token: result,
          isNotify: true,
        })
        router.post(route('fcmToken'), token)
        localStorage.setItem('isNotify',1)
      })
    }
  }else{
    const token = reactive({
      isNotify: false,
    })
    router.post(route('fcmToken'), token)
    localStorage.setItem('isNotify',0)
  }
  console.log('permissionStatus: ', permissionStatus.value)
}
const toggleData = (status) => {
  let x = status == 0 ? false : true
  statusData.value = !x
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
