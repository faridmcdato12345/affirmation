<template>
  <Settings>
    <div class="w-full pl-16 pr-8 py-16 h-full">
      <form @submit.prevent="save">
        <div class="mb-12 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green">
            Report Bug
          </h1>
        </div>
        <div class="mb-12">
          <h4 class="text-theme-green">
            Write a report to help
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
        <Button label="Cancel" color="error" @click.prevent="successMessage = false" />
      </div>
    </Modal>
  </Settings>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import Settings from '../Settings.vue'
import Button from '../../Components/Auth/Button.vue'
import route from 'ziggy-js'
import { ref } from 'vue'
import Modal from '../../Components/Modal.vue'
import InputError from '../../Components/InputError.vue'

const successMessage = ref(false)
const form = useForm({
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
</script>