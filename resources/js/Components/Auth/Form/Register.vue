<template>
  <div>
    <CallSign value="Sign Up" />
    <form class="space-y-4 md:space-y-6" @submit.prevent="register">
      <div>
        <InputLabel for="name" value="Name" />
        <BaseInput 
          v-model="registrationForm.name" 
          type="text" 
          label="Full Name"
          autofocus
        />
        <div>
          <InputError class="mt-2" :message="registrationForm.errors.name" />
        </div>
      </div>
      <div>
        <InputLabel for="email" value="Email" />
        <BaseInput 
          v-model="registrationForm.email" 
          type="email"
          label="example@sample.com"
        />
        <div>
          <InputError class="mt-2" :message="registrationForm.errors.email" />
        </div>
      </div>
      <div class="relative">
        <InputLabel for="password" value="Password" />
        <div class="relative">
          <BaseInput 
            v-if="showPass"
            v-model="registrationForm.password" 
            type="password"
            label="••••••••"
          />
          <BaseInput 
            v-else 
            v-model="registrationForm.password" 
            type="text" 
            label="••••••••"
          />
          <ShowPassword v-model="showPass" />
        </div>
        <div>
          <InputError class="mt-2" :message="registrationForm.errors.password" />
        </div>
      </div>
      <div class="relative">
        <InputLabel for="confirm_password" value="Confirm Password" />
        <div class="relative">
          <BaseInput 
            v-if="showPass" 
            v-model="registrationForm.password_confirmation" 
            type="password"
            label="••••••••"
          />
          <BaseInput 
            v-else 
            v-model="registrationForm.password_confirmation" 
            type="text"
            label="••••••••"
          />
          <ShowPassword v-model="showPass" />
        </div>
      </div>
      <AuthButton label="Sign up" />
      <p class="text-sm font-light text-gray-900 dark:text-gray-900 flex justify-center items-center">
        Already have an account? 
        <Link :href="route('login')" class="font-bold text-theme-green hover:underline dark:text-theme-green hover:text-hover-theme-green">
          Sign in
        </Link>
      </p>
    </form>
  </div>
</template>
<script setup>
import { ref } from "vue"
import route from "ziggy-js"
import {Link, useForm} from "@inertiajs/vue3"
import InputError from "../../InputError.vue"
import InputLabel from "../../InputLabel.vue"
import ShowPassword from "./Icons/ShowPassword.vue"
import CallSign from "../../CallSign.vue"
import BaseInput from "./Input/BaseInput.vue"
import AuthButton from "../Button.vue"

defineProps({
  errors: Object
})
const registrationForm = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: ""
})
const showPass = ref(true)
const register = () => {
  registrationForm.post(route("register"),{
    onFinish: () => [registrationForm.reset("password"),registrationForm.reset("password_confirmation")]
  })
}
</script>