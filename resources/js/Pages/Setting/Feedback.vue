<template>
  <Settings>
    <div class="w-full pl-16 pr-8 py-16 h-full">
      <form @submit.prevent="save">
        <div class="mb-12 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green">
            Feedback
          </h1>
        </div>
        <div class="mb-12">
          <h4 class="text-theme-green">
            Write a feedback to help
          </h4>
        </div>
        <textarea 
          id="description" 
          v-model="form.description" 
          name="" 
          cols="200" 
          rows="10"
          class="border-2 border-hover-theme-green w-full"></textarea>
        <InputError class="mt-2 mb-2" :message="form.errors.description" />
        <Button label="Submit" />
      </form>
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
  </Settings>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/solid'
import Settings from '../Settings.vue'
import Button from '../../Components/Auth/Button.vue'
import route from 'ziggy-js'
import { ref } from 'vue'
import Modal from '../../Components/Modal.vue'
import InputError from '../../Components/InputError.vue'

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