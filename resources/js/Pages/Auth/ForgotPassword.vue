<template>
  <AuthLayout>
    <CallSign value="Forgot Password" />
    <div class="mb-4 text-sm text-gray-950 dark:text-gray-950">
      Forgot your password? No problem. Just let us know your email address and we will email you a password reset
      link that will allow you to choose a new one.
    </div>
   
    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

        <BaseInput
          id="email"
          v-model="form.email"
          type="email"
          label="example@sample.com"
          required
          autofocus
          autocomplete="username" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="flex items-center justify-center w-full mt-4 flex-col">
        <AuthButton label="Email Password Reset Link" />
        <!-- <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Email Password Reset Link
        </PrimaryButton> -->
        <div class="w-full">
          <CancelButton />
        </div>
      </div>
    </form>
  </AuthLayout>
</template>
<script setup>
import AuthLayout from '../../Layouts/Auth.vue'
import InputError from '../../Components/InputError.vue'
import InputLabel from '../../Components/InputLabel.vue'
import CancelButton from '../../Components/CancelButton.vue'
import {useForm } from '@inertiajs/vue3'
import CallSign from '../../Components/CallSign.vue'
import AuthButton from '../../Components/Auth/Button.vue'
import BaseInput from '../../Components/Auth/Form/Input/BaseInput.vue'
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