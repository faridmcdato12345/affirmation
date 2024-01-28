<template>
  <div class="">
    <div class="mb-4 mt-4">
      <h1 class="font-normal mb-0">
        Sign In
      </h1>
      <p>Please enter your credentials to proceed to your account.</p>
    </div>
    <form class="" @submit.prevent="submit">
      <FormInput id="email" v-model="loginForm.email" label="Email Address" :error="loginForm.errors.email" required />
      <FormInput id="password" v-model="loginForm.password" :type="showPassword ? 'text' : 'password'" label="Password" :error="loginForm.errors.password" required>
        <template #icon-right>
          <component :is="showPassword ? EyeSlashIcon : EyeIcon" class="text-theme-green w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" @click.prevent="showPassword = !showPassword" />
        </template>
      </FormInput>
      <div class="flex items-center justify-between mt-2">
        <div class="flex mx-2">
          <input 
            id="green-checkbox" 
            v-model="loginForm.remember" 
            checked 
            type="checkbox" 
            value="" 
            class="accent-theme-green w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
          <label for="green-checkbox" class="ml-2 text-sm font-medium text-gray-900">Remember me</label>
        </div>
        <Link :href="route('forgot.password')" class="hover:text-green-700 text-sm font-medium text-green-600 hover:underline dark:text-primary-500">
          Forgot Password?
        </Link>
      </div>
      <Button label="Sign in" class="mt-4" btn-block color="success" :loading="loading" type="submit" />
      <p class="text-sm text-gray-700 dark:text-gray-900 flex justify-center items-center mt-4">
        Don’t have an account yet?&nbsp;<span><Link :href="route('register')" class="font-medium text-green-600 hover:underline dark:text-theme-green hover:text-green-700">
          Sign up
        </Link></span>
      </p>
    </form>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'
import Button from '../../Button.vue'
import FormInput from '../../FormInput.vue'
import route from 'ziggy-js'

defineProps({
  errors: Object
})

const loginForm = useForm({
  email: '',
  password: '',
  remember: false,
  timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
})

const showPassword = ref(false)
const loading = ref(false)

const submit = () => {
  loading.value = true
  loginForm.post(route('login'),
    {
      onFinish: () => {
        loading.value = false
        loginForm.reset('password')
      },
    })
}
</script>
