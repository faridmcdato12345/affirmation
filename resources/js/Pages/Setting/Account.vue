<template>
  <div>
    <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings">
      <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
        <form @submit.prevent="save">
          <div class="mb-9 border-b-2 border-hover-theme-green pb-8">
            <h1 class="text-theme-green text-center md:text-left font-semibold">
              Account Settings
            </h1>
          </div>
          <div class="mb-10">
            <h1 class="text-theme-green font-medium">
              Personal Information
            </h1>
            <p>Please make sure to enter a correct information</p>
          </div>
          <FormInput id="fullname" v-model="form.name" label="Full Name" type="text" />
          <FormInput id="email" v-model="form.email" type="email" label="Email Address" class="mt-6" />
          <br />
          <Button label="Save Changes" />
        </form>
      </div>
    </component>
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
        <Button label="Close" color="error" @click.prevent="modal = false" />
      </div>
    </Modal>
  </div>
</template>
<script setup>
import AuthenticateMobileSettingLayout from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { ref } from 'vue'
import { isMobile } from 'mobile-device-detect'
import { useForm } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import Button from '../../Components/Auth/Button.vue'
import FormInput from '../../Components/FormInput.vue'
import Modal from '../../Components/Modal.vue'

const props = defineProps({
  user: Object
})
const form = useForm({
  name: props.user.name,
  email: props.user.email
})
const modal = ref(false)
const modalTextHeader = ref('')
const modalTextBody = ref('')
const modalIcon = ref(true)

const save = () => {
  form.patch(route('setting.user.update',props.user.id),{
    onSuccess: () => {
      modal.value = true,
      modalTextBody.value = 'Successfully changed the personal infomation',
      modalTextHeader.value = 'Success!'
    }
  })
}
</script>
