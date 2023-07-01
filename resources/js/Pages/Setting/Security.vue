<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayoutVue : Settings">
    <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
      <form @submit.prevent="save">
        <div class="mb-9 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green md:text-left text-center">
            Security Settings
          </h1>
        </div>
        <div class="mb-8">
          <h1 class="text-theme-green font-medium">
            Change Password
          </h1>
          <p>Please make sure to enter a secure password</p>
        </div>
        <FormInput id="old_password" v-model="form.current_password" class="md:mb-4" label="Current Password" :type="showPass.password ? 'text' : 'password'" :error="errors.current_password">
          <template #icon-right>
            <component :is="showPass.password ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.password = !showPass.password" />
          </template>
        </FormInput>
        <div class="md:flex md:justify-between gap-x-3">
          <FormInput id="new_password" v-model="form.password" :type="showPass.new_password ? 'text' : 'password'" label="New Password" class="w-1/2" :error="errors.password">
            <template #icon-right>
              <component :is="showPass.new_password ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.new_password = !showPass.new_password" />
            </template>
          </FormInput>
          <FormInput id="confirm_new_password" v-model="form.password_confirmation" :type="showPass.confirm_new_password ? 'text' : 'password'" label="Confirm New Password" class="w-1/2">
            <template #icon-right>
              <component :is="showPass.confirm_new_password ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.confirm_new_password = !showPass.confirm_new_password" />
            </template>
          </FormInput>
        </div>
        <br />
        <Button label="Save Changes" />
      </form>
    </div>
  </component>
</template>
<script setup>
import { isMobile } from 'mobile-device-detect'
import { useForm } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import AuthenticateMobileSettingLayoutVue from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import { reactive } from 'vue'
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'
import Button from '../../Components/Auth/Button.vue'
import FormInput from '../../Components/FormInput.vue'

defineProps({
  errors: Object
})

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

const showPass = reactive({
  old_password: false,
  new_password: false,
  confirm_new_password: false
})

const save = () => {
  form.patch(route('setting.security.update'))
}
</script>
