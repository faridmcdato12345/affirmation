<template>
  <AuthLayout>
    <h1 class="font-normal mb-0 mt-5">
      Forgot Password
    </h1>
    <div class="mb-4 text-sm text-gray-700 dark:text-gray-950 mt-2">
      Please enter email address and we will email you a password reset
      link that will allow you to choose a new one.
    </div>
   
    <form @submit.prevent="submit">
      <FormInput id="email" v-model="form.email" type="email" label="Email Address" required />
      <div class="flex items-center justify-center w-full mt-4 flex-col">
        <Button type="submit" label="Email Password Reset Link" color="success" btn-block />
        <Button component-type="link" :href="route('login')" label="Cancel Reset" class="mt-1" color="error" btn-block />
      </div>
    </form>
  </AuthLayout>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import FormInput from '../../Components/FormInput.vue'
import AuthLayout from '../../Layouts/Auth.vue'
import Button from '../../Components/Button.vue'
import route from 'ziggy-js'

defineProps({
  status: {
    type: String,
  },
})

const form = useForm({
  email: '',
})
const submit = () => {
  form.post(route('password.email'))
}
</script>
<style scoped>

</style>