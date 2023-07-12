<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings">
    <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
      <form @submit.prevent="save">
        <div class="mb-6 border-b-2 border-hover-theme-green pb-5">
          <h1 class="text-theme-green md:text-left text-center">
            Report Bug
          </h1>
        </div>
        <div class="mb-4">
          <h1 class="text-theme-green font-medium">
            Tell Us What Happened
          </h1>
          <p>Briefly discuss the problem that you encountered so we can help more.</p>
        </div>
        <textarea
          id="description"
          v-model="form.description"
          name=""
          cols="200"
          rows="10"
          class="border-2 border-hover-theme-green w-full rounded-md"></textarea>
        <InputError class="mt-2 mb-2" :message="form.errors.description" />
        <Button label="Submit" class="mt-3" />
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
  </component>
</template>
<script setup>
import AuthenticateMobileSettingLayout from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { isMobile } from 'mobile-device-detect'
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
