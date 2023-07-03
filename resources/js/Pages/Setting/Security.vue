<template>
  <component :is="isMobile ? AuthenticateMobileSettingLayoutVue : Settings">
    <div class="md:w-full md:pl-16 md:pr-8 md:py-16 h-full">
      <form @submit.prevent="save">
        <div class="mb-12 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green md:text-left text-center">
            Security Settings
          </h1>
        </div>
        <div class="mb-12">
          <h4 class="text-theme-green">
            Change Password
          </h4>
        </div>
        <FormInput id="old_password" v-model="form.old_password" class="md:mb-10" label="Old Password" :type="showPass.password ? 'text' : 'password'">
          <template #icon-right>
            <component :is="showPass.password ? EyeSlashIcon : EyeIcon" class="text-theme-green w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" @click.prevent="showPass.password = !showPass.password" />
          </template>
        </FormInput>
        <div class="md:flex md:justify-between">
          <FormInput id="new_password" v-model="form.new_password" :type="showPass.new_password ? 'text' : 'password'" label="New Password" class="md:w-[48%]">
            <template #icon-right>
              <component :is="showPass.new_password ? EyeSlashIcon : EyeIcon" class="text-theme-green w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" @click.prevent="showPass.new_password = !showPass.new_password" />
            </template>
          </FormInput>
          <FormInput id="confirm_new_password" v-model="form.confirm_new_password" :type="showPass.confirm_new_password ? 'text' : 'password'" label="Confirm New Password" class="md:w-[48%]">
            <template #icon-right>
              <component :is="showPass.confirm_new_password ? EyeSlashIcon : EyeIcon" class="text-theme-green w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" @click.prevent="showPass.confirm_new_password = !showPass.confirm_new_password" />
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

const form = useForm({
  old_password: '',
  new_password: ''
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