<template>
  <div>
    <component :is="isMobile ? AuthenticateMobileSettingLayout : Settings" :route-name="routeName">
      <div :class="isMobile ? 'w-full h-full p-4' : ''">
        <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
          <form @submit.prevent="save">
            <div v-if="!isMobile" class="mb-5 border-b-2 border-hover-theme-green pb-4">
              <h1 class="dark:text-white text-theme-green text-center md:text-left font-semibold">
                Account Settings
              </h1>
            </div>
            <div class="mb-5">
              <h1 class="dark:text-white text-theme-green font-medium">
                Personal Information
              </h1>
              <p class="dark:text-gray-400">
                Please make sure to enter a correct information
              </p>
            </div>
            <FormInput id="fullname" v-model="form.name" label="Full Name" type="text" />
            <FormInput id="email" v-model="form.email" type="email" label="Email Address" class="mt-6" />
            <br />
            <Button label="Save Changes" btn-block color="success" type="submit" />
          </form>

          <hr class="my-6" />

          <form @submit.prevent="updatePassword">
            <div class="mb-8">
              <h1 class="dark:text-white text-theme-green font-medium">
                Update Password
              </h1>
              <p class="dark:text-gray-400">
                Please make sure to enter a secure password
              </p>
            </div>
            <FormInput 
              id="old_password" 
              v-model="formPass.current_password" 
              class="md:mb-4" 
              label="Current Password" 
              :type="showPass.password ? 'text' : 'password'" 
              :error="errors.current_password">
              <template #icon-right>
                <component 
                  :is="showPass.password ? EyeSlashIcon : EyeIcon" 
                  class="text-theme-green dark:text-gray-500 w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" 
                  @click.prevent="showPass.password = !showPass.password" />
              </template>
            </FormInput>
            <div class="md:flex md:justify-between gap-x-3">
              <FormInput 
                id="new_password" 
                v-model="formPass.password" 
                :type="showPass.new_password ? 'text' : 'password'" 
                label="New Password" class="w-full md:w-1/2" :error="errors.password">
                <template #icon-right>
                  <component 
                    :is="showPass.new_password ? EyeSlashIcon : EyeIcon" 
                    class="text-theme-green dark:text-gray-500 w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" 
                    @click.prevent="showPass.new_password = !showPass.new_password" />
                </template>
              </FormInput>
              <FormInput 
                id="confirm_new_password" v-model="formPass.password_confirmation" 
                :type="showPass.confirm_new_password ? 'text' : 'password'" 
                label="Confirm New Password" class="w-full md:w-1/2">
                <template #icon-right>
                  <component 
                    :is="showPass.confirm_new_password ? EyeSlashIcon : EyeIcon" 
                    class="text-theme-green dark:text-gray-500 w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" 
                    @click.prevent="showPass.confirm_new_password = !showPass.confirm_new_password" />
                </template>
              </FormInput>
            </div>
            <br />
            <Button label="Update Password" btn-block color="success" type="submit" />
          </form>

          <hr class="my-6" />

          <div class="mb-8 flex justify-between">
            <div>
              <h1 class="dark:text-white text-theme-green font-medium mb-0">
                Dark Mode
              </h1>
              <p class="dark:text-gray-400">
                Protect your eyes and enable dark mode
              </p>
            </div>
            <label class="relative inline-flex items-center mb-4 cursor-pointer">
              <input 
                type="checkbox" 
                class="sr-only peer" 
                :checked="isDarkMode"
                @click="toggleDarkMode" />
              <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[10px] sm:after:top-[10px] after:left-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
            </label>
          </div>

          <hr class="my-6" />
          <div class="mb-8 flex justify-between items-center">
            <div>
              <h1 class="dark:text-white text-theme-green font-medium mb-0">
                Background Theme
              </h1>
              <p class="dark:text-gray-400">
                Change your background to your preference
              </p>
            </div>
            <Button label="Themes" color="success" component-type="link" href="/themes" />
          </div>
          
          <hr class="my-6" />
          <div class="mb-8 flex justify-between items-center">
            <div>
              <h1 class="dark:text-white text-theme-green font-medium mb-0">
                Intro Tutorial
              </h1>
              <p class="dark:text-gray-400">
                Walkthrough on how the application works
              </p>
            </div>
            <Button label="Show Intro" color="success" @click.prevent="enableIntro" />
          </div>
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
import { useForm, router } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import Modal from '../../Components/Modal.vue'
import Button from '../../Components/Button.vue'
import FormInput from '../../Components/FormInput.vue'
import { useToggleDarkMode } from '../../Composables/useToggleDarkMode'
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

const { isDarkMode, toggleDarkMode } = useToggleDarkMode()

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

const enableIntro = async () => {
  router.patch(route('intro.show'), {} ,{
    onSuccess: () => {
      router.get(route('home'))
    }
  })
}
</script>
