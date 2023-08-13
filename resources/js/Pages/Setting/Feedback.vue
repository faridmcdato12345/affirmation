<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route_name="routeName">
    <div :class="isMobile ? 'w-full h-full p-4' : ''">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <form @submit.prevent="save">
          <div v-if="!isMobile" class="mb-9 border-b-2 border-hover-theme-green pb-8">
            <h1 class="text-theme-green md:text-left text-center">
              Feedback
            </h1>
          </div>
          <div class="mb-6">
            <h1 class="text-theme-green font-medium">
              Write a feedback
            </h1>
            <p>We would like your feedback to help us improve our app</p>
          </div>
          <textarea
            id="description"
            v-model="form.description"
            name=""
            cols="200"
            rows="10"
            placeholder="Write your feedback"
            class="border-2 border-hover-theme-green w-full rounded-md px-2 py-1 dark:bg-gray-800"></textarea>
          <InputError class="mt-2 mb-2" :message="form.errors.description" />
          <Button label="Submit" class="mt-3" />
        </form>
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
  </component>
</template>
<script setup>
import AuthenticateMobileSettingLayout from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { isMobile } from 'mobile-device-detect'
import { useForm } from '@inertiajs/vue3'
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/solid'
import Settings from '../Settings.vue'
import Button from '../../Components/Auth/Button.vue'
import route from 'ziggy-js'
import { ref } from 'vue'
import Modal from '../../Components/Modal.vue'
import InputError from '../../Components/InputError.vue'
const routeName = ref('Feedback')
const modal = ref(false)
const modalTextHeader = ref('')
const modalTextBody = ref('')
const modalIcon = ref(true)
const form = useForm({
  description: '',
})

const save = () => {
  form.post(route('setting.feedback.store'),{
    onSuccess: () => {
      form.reset('description'),
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
