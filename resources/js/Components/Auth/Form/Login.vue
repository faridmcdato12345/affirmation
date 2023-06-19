<template>
  <div>
    <CallSign value="Sign In" />
    <form class="space-y-4 md:space-y-6" @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />
        <BaseInput
          v-model="loginForm.email"
          label="example@sample.com"
          type="email"
          autofocus />
        <div>
          <InputError class="mt-2" :message="loginForm.errors.email" />
        </div>
      </div>
      <div class="relative">
        <InputLabel for="password" value="Password" />
        <div class="relative">
          <BaseInput 
            v-if="showPass" 
            v-model="loginForm.password" 
            type="password"
            label="••••••••" />
          <BaseInput
            v-else 
            v-model="loginForm.password" 
            type="text" 
            label="••••••••" />
          <ShowPassword v-model="showPass" />
        </div>
        <div>
          <InputError class="mt-2" :message="loginForm.errors.password" />
        </div>
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center mr-4">
          <input id="green-checkbox" checked type="checkbox" value="" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
          <label for="green-checkbox" class="ml-2 text-sm font-medium text-gray-900">Remember me</label>
        </div>
        <Link :href="route('forgot.password')" class="hover:text-hover-theme-green text-sm font-medium text-theme-green hover:underline dark:text-primary-500">
          Forgot password?
        </Link>
      </div>
      <AuthButton label="Sign in" />
      <p class="text-sm font-light text-gray-900 dark:text-gray-900 flex justify-center items-center">
        Don’t have an account yet? <span><Link :href="route('register')" class="font-bold text-theme-green hover:underline dark:text-theme-green hover:text-hover-theme-green">
          Sign up
        </Link></span>
      </p>
    </form>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import {Link, useForm} from '@inertiajs/vue3'
import InputError from '../../InputError.vue'
import InputLabel from '../../InputLabel.vue'
import ShowPassword from './Icons/ShowPassword.vue'
import CallSign from '../../CallSign.vue'
import BaseInput from './Input/BaseInput.vue'
import AuthButton from '../Button.vue'
import route from 'ziggy-js'
defineProps({
  errors: Object
})
const loginForm = useForm({
  email: '',
  password: '',
  remember: false
})
const showPass = ref(true)
const submit = () => {
  loginForm.post(route('login'),{
    onFinish: () => loginForm.reset('password'),
  })
}
</script>