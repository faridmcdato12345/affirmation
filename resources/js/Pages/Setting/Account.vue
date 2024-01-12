<template>
  <div>
    <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName">
      <div :class="isMobile ? 'w-full h-full p-4' : ''">
        <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
          <form @submit.prevent="save">
            <div v-if="!isMobile" class="mb-5 border-b border-gray-700 pb-2">
              <h1 class="dark:text-white text-theme-green text-center md:text-left font-semibold">
                Account Settings
              </h1>
            </div>
            <div class="mb-5">
              <h1 class="dark:text-white text-theme-green font-medium mb-0">
                Personal Information
              </h1>
              <p class="dark:text-gray-400">
                Please ensure that your personal information details are correct.
              </p>
            </div>
            <p class="mt-3 mb-0 text-gray-700 dark:text-gray-300 text-base">
              Full Name
            </p>
            <FormInput 
              id="fullname" 
              v-model="form.name" 
              label="Full Name" 
              transparent
              type="text" />
            <p class="mt-3 mb-0 text-gray-700 dark:text-gray-300 text-base">
              Email Address
            </p>
            <FormInput 
              id="email" 
              v-model="form.email" 
              type="email" 
              label="Email Address" 
              transparent
              class="" />
            <br />
            <Button label="Save Changes" btn-block color="success" type="submit" />
          </form>

          <hr class="my-10 border-0 border-b dark:border-gray-700" />

          <form @submit.prevent="updatePassword">
            <div class="mb-3">
              <h1 class="dark:text-white text-theme-green font-medium">
                Update Password
              </h1>
              <p class="text-gray-700 dark:text-gray-300">
                Please make sure to enter a secure password and avoid sharing it to others.
              </p>
            </div>
            <p class="mb-0 text-gray-700 dark:text-gray-300 text-base">
              Current Password
            </p>
            <FormInput 
              id="old_password" 
              v-model="formPass.current_password" 
              class="md:mb-4" 
              label="Current Password" 
              placeholder="Enter current password"
              :type="showPass.password ? 'text' : 'password'" 
              transparent
              :error="errors.current_password">
              <template #icon-right>
                <component 
                  :is="showPass.password ? EyeSlashIcon : EyeIcon" 
                  class="text-theme-green dark:text-gray-500 w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" 
                  @click.prevent="showPass.password = !showPass.password" />
              </template>
            </FormInput>
            <div class="md:flex md:justify-between gap-x-3">
              <div class="w-full">
                <p class="mb-0 text-gray-700 dark:text-gray-300 text-base">
                  New Password
                </p>
                <FormInput
                  id="new_password"
                  v-model="formPass.password"
                  :type="showPass.new_password ? 'text' : 'password'"
                  label="New Password"
                  class="w-full"
                  transparent
                  placeholder="Enter New Password"
                  :error="errors.password">
                  <template #icon-right>
                    <component
                      :is="showPass.new_password ? EyeSlashIcon : EyeIcon"
                      class="text-theme-green dark:text-gray-500 w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out"
                      @click.prevent="showPass.new_password = !showPass.new_password" />
                  </template>
                </FormInput>
              </div>
              <div class="w-full">
                <p class="mb-0 text-gray-700 dark:text-gray-300 text-base">
                  Confirm Password
                </p>
                <FormInput
                  id="confirm_new_password"
                  v-model="formPass.password_confirmation"
                  :type="showPass.confirm_new_password ? 'text' : 'password'"
                  placeholder="Confirm Password"
                  label="Confirm New Password"
                  transparent
                  class="w-full">
                  <template #icon-right>
                    <component
                      :is="showPass.confirm_new_password ? EyeSlashIcon : EyeIcon"
                      class="text-theme-green dark:text-gray-500 w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out"
                      @click.prevent="showPass.confirm_new_password = !showPass.confirm_new_password" />
                  </template>
                </FormInput>
              </div>
            </div>
            <br />
            <Button label="Update Password" btn-block color="success" type="submit" />
          </form>          
        </div>
      </div>
    </component>

    <Modal v-model="modal">
      <div class="text-cr">
        <component
          :is="modalIcon ? CheckCircleIcon : XCircleIcon"
          class="w-14 mx-auto text-green-600 duration-200 ease-out" />
        <h1 class="mt-2 dark:text-white flex justify-center items-center">
          {{ modalTextHeader }}
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          {{ modalTextBody }}
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Close" color="success" btn-block @click.prevent="modal = false" />
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { ref, reactive } from 'vue'
import { isMobile } from 'mobile-device-detect'
import { useForm } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import Modal from '../../Components/Modal.vue'
import Button from '../../Components/Button.vue'
import FormInput from '../../Components/FormInput.vue'
import AuthenticateMobileSettingLayout from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { CheckCircleIcon, EyeIcon, EyeSlashIcon, XCircleIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  user: Object,
  errors: Object
})

const routeName = ref('Account Settings')
const form = useForm({
  name: props.user.name,
  email: props.user.email
})
const modal = ref(false)
const modalTextHeader = ref('')
const modalTextBody = ref('')
const modalIcon = ref(true)

const formPass = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const showPass = reactive({
  old_password: false,
  new_password: false,
  confirm_new_password: false
})

const updatePassword = () => {
  formPass.patch(route('setting.security.update'))
}

const save = () => {
  form.patch(route('setting.user.update', props.user.id),{
    onSuccess: () => {
      modal.value = true,
      modalTextBody.value = 'Successfully changed the personal infomation',
      modalTextHeader.value = 'Success!'
    }
  })
}

</script>
