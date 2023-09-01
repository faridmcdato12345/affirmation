<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <form @submit.prevent="save">
          <div class="mb-4">
            <h1 class="dark:text-white text-theme-green font-semibold">
              Report an Issue
            </h1>
            <p class="dark:text-gray-300">
              Briefly discuss the problem that you encountered so we can help more.
            </p>
          </div>
          <textarea
            id="description"
            v-model="form.description"
            name=""
            cols="200"
            rows="5"
            placeholder="Help us improve our app"
            class="border-2 border-hover-theme-green w-full rounded-md px-2 dark:bg-gray-800"></textarea>
          <InputError class="mt-2 mb-2" :message="form.errors.description" />
          <Button label="Report Issue" class="mt-3" btn-block color="success" />
        </form>
        
        <hr class="mt-8 mb-4" />

        <form class="mt-8" @submit.prevent="sendFeedback">
          <div class="mb-6">
            <h1 class="dark:text-white text-theme-green font-semibold">
              Write a Feedback
            </h1>
            <p class="dark:text-gray-300">
              We would like your feedback to help us improve our app or you can request a feature if you want 
            </p>
          </div>
          <textarea
            id="description"
            v-model="feedbackForm.description"
            name=""
            cols="200"
            rows="5"
            placeholder="Write your feedback"
            class="border-2 border-hover-theme-green w-full rounded-md px-2 py-1 dark:bg-gray-800"></textarea>
          <InputError class="mt-2 mb-2" :message="feedbackForm.errors.description" />
          <Button label="Send Feedback" class="mt-3" btn-block color="success" />
        </form>
      </div>
    </div>
    
    <Modal v-model="successMessage">
      <div class="text-center">
        <CheckCircleIcon class="w-14 mx-auto text-green-600" />
        <h1 class="mt-2">
          Thank you!
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          Successfully submitted a bug report. Your help is much appreciated!
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Close" color="error" @click.prevent="successMessage = false" />
      </div>
    </Modal>

     
    <Modal v-model="modal">
      <div class="text-center">
        <component
          :is="modalIcon ? CheckCircleIcon : XCircleIcon"
          class="w-14 mx-auto text-green-600 duration-200 ease-out" />
        <h1 class="mt-2">
          {{ modalTextHeader }}
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          {{ modalTextBody }}
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Close" color="error" @click.prevent="modal = false" />
      </div>
    </Modal>
  </component>
</template>
<script setup>
import { ref } from 'vue'
import route from 'ziggy-js'
import { isMobile } from 'mobile-device-detect'
import { useForm } from '@inertiajs/vue3'

import AuthenticateMobileSettingLayout from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import Settings from '../Settings.vue'
import Button from '../../Components/Button.vue'
import Modal from '../../Components/Modal.vue'
import InputError from '../../Components/InputError.vue'

const routeName = ref('Get In Contact')
const successMessage = ref(false)

const form = useForm({
  description: '',
})

/**
 * Feature Request
 */
const modalTextHeader = ref('')
const modalTextBody = ref('')
const modalIcon = ref(true)
const modal = ref(false)

const feedbackForm = useForm({
  description: '',
})


const save = () => {
  form.post(route('setting.reportbug.store'),{
    onSuccess: () => {
      form.reset('description'),
      successMessage.value = true
    }
  })
}


const sendFeedback = () => {
  feedbackForm.post(route('setting.feedback.store'),{
    onSuccess: () => {
      feedbackForm.reset('description'),
      modal.value = true,
      modalTextBody.value = 'Successfully submitted a feedback. Your feedback will undergo thorough analysis and study!',
      modalTextHeader.value = 'Thank you'
    },
    onError: () => {
      modalIcon.value = false
    }
  })
}
</script>
