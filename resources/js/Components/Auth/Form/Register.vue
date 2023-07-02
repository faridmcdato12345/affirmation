<template>
  <div class="mt-4">
    <h1 class="font-normal mb-0">
      Register Account
    </h1>
    <p>Please fill-out some informations for your account</p>
    <form class="mt-3" @submit.prevent="register">
      <FormInput id="fullname" v-model="registrationForm.name" label="Full Name" :error="registrationForm.errors.name" required />
      <FormInput id="email" v-model="registrationForm.email" type="email" label="Email Address" :error="registrationForm.errors.email" required />
      <FormInput id="password" v-model="registrationForm.password" :type="showPass.password ? 'text' : 'password'" label="Password" :error="registrationForm.errors.password" required>
        <template #icon-right>
          <component :is="showPass.password ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.password = !showPass.password" />
        </template>
      </FormInput>
      <FormInput id="confirm_password" v-model="registrationForm.password_confirmation" :type="showPass.confirm ? 'text' : 'password'" label="Confirm Password" required>
        <template #icon-right>
          <component :is="showPass.confirm ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.confirm = !showPass.confirm" />
        </template>
      </FormInput>
      <Button label="Sign Up" class="mt-4" btn-block color="success" type="submit" :loading="loading" />
      <p class="text-sm text-gray-700 dark:text-gray-900 flex justify-center items-center mt-4">
        Already have an account?
        <Link :href="route('login')" class="font-medium text-green-600 hover:underline dark:text-theme-green hover:text-green-700">
          &nbsp;Sign in
        </Link>
      </p>
    </form>
  </div>
</template>
<script setup>
import route from 'ziggy-js'
import { reactive, ref } from 'vue'
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'
import { Link, useForm } from '@inertiajs/vue3'
import FormInput from '../../FormInput.vue'
import Button from '../../Button.vue'

defineProps({
  errors: Object
})

const registrationForm = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const showPass = reactive({
  password: false,
  confirm: false
})

const loading = ref(false)

const register = () => {
  loading.value = true
  registrationForm.post(route('register'),{
    onFinish: () => {
      [registrationForm.reset('password'),registrationForm.reset('password_confirmation')]
      loading.value = false
    }
  })
}
</script>
