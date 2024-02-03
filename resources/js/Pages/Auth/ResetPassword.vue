<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <form @submit.prevent="submit">
      <FormInput 
        id="email" 
        v-model="form.email" 
        label="Email Address" 
        :error="form.errors.email" 
        autofocus 
        required
        readonly
        autocomplete="username" />
      <FormInput id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'" label="Password" :error="form.errors.password" required @input="checkPassword">
        <template #icon-right>
          <component :is="showPassword ? EyeSlashIcon : EyeIcon" class="text-theme-green w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" @click.prevent="showPassword = !showPassword" />
        </template>
      </FormInput>
      <FormInput id="password" v-model="form.password_confirmation" :type="showPassword ? 'text' : 'password'" label="Confirm Password" :error="form.errors.password_confirmation" required>
        <template #icon-right>
          <component :is="showPassword ? EyeSlashIcon : EyeIcon" class="text-theme-green w-5 h-5 cursor-pointer hover:text-hover-theme-green duration-200 ease-out" @click.prevent="showPassword = !showPassword" />
        </template>
      </FormInput>
      <div class="flex mt-2 gap-x-2 px-1">
        <div class="rounded-lg flex-auto relative h-1.5 bg-gray-300">
          <div 
            class="absolute left-0 bg-green-600 top-0 transition-all ease-in-out duration-300 w-0 z-10 h-1.5 rounded-lg" 
            :style="{ width: passStrength >= 1 ? '100%' : '0%'}"></div>
        </div>
        <div class="rounded-lg flex-auto relative h-1.5 bg-gray-300">
          <div 
            class="absolute left-0 bg-green-600 top-0 transition-all ease-in-out duration-300 z-10 h-1.5 rounded-lg" 
            :style="{ width: passStrength >= 2 ? '100%' : '0%'}"></div>
        </div>
        <div class="rounded-lg flex-auto relative h-1.5 bg-gray-300">
          <div 
            class="absolute left-0 bg-green-600 top-0 transition-all ease-in-out duration-300 z-10 h-1.5 rounded-lg" 
            :style="{ width: passStrength >= 3 ? '100%' : '0%'}"></div>
        </div>
        <div class="rounded-lg flex-auto relative h-1.5 bg-gray-300">
          <div 
            class="absolute left-0 bg-green-600 top-0 transition-all ease-in-out duration-300 z-10 h-1.5 rounded-lg" 
            :style="{ width: passStrength >= 4 ? '100%' : '0%'}"></div>
        </div>
        <div class="rounded-lg flex-auto relative h-1.5 bg-gray-300">
          <div 
            class="absolute left-0 bg-green-600 top-0 transition-all ease-in-out duration-300 z-10 h-1.5 rounded-lg" 
            :style="{ width: passStrength >= 5 ? '100%' : '0%'}"></div>
        </div>
      </div>
      <div class="mt-2 ml-1">
        <p class="leading-4">
          Password must be at least 
          <span :class="contains_eight_characters ? 'text-green-700' : 'text-red-600'">8 characters</span>, 
          <span :class="contains_number ? 'text-green-700' : 'text-red-600'">contains a number</span>, 
          <span :class="contains_special_character ? 'text-green-700' : 'text-red-600'">special character</span>, 
          <span :class="contains_uppercase ? 'text-green-700' : 'text-red-600'">uppercase</span>, 
          <span :class="contains_lowercase ? 'text-green-700' : 'text-red-600'">lowercase</span>, 
        </p>
      </div>
      <Button label="Reset Password" class="mt-4" btn-block color="success" :loading="loading" type="submit" />
    </form>
  </GuestLayout>
</template>
<script setup>
import GuestLayout from '../../Layouts/Auth.vue'
// import InputError from '../../Components/InputError.vue'
// import InputLabel from '../../Components/InputLabel.vue'
// import PrimaryButton from '../../Components/PrimaryButton.vue'
// import TextInput from '../../Components/TextInput.vue'
import Button from '../../Components/Button.vue'
import { Head, useForm } from '@inertiajs/vue3'
import FormInput from '../../Components/FormInput.vue'
import route from 'ziggy-js'
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'
import { ref } from 'vue'


const showPassword = ref(false)
const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

const password_length = ref(0)
const contains_eight_characters = ref(false)
const contains_number = ref(false)
const contains_uppercase = ref(false)
const contains_lowercase = ref(false)
const contains_special_character = ref(false)
const passStrength = ref(0)

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
const checkPassword = () => {
  password_length.value = form.password.length
  const format = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/ // eslint-disable-line no-undef
			
  contains_eight_characters.value = password_length.value > 8
  contains_number.value = /\d/.test(form.password)
  contains_uppercase.value = /[A-Z]/.test(form.password)
  contains_lowercase.value = /[a-z]/.test(form.password)
  contains_special_character.value = format.test(form.password)

  checkPasswordStrength()
}

const checkPasswordStrength = () => {
  passStrength.value = 0
  if(contains_eight_characters.value) passStrength.value += 1
  if(contains_number.value) passStrength.value += 1
  if(contains_uppercase.value) passStrength.value += 1
  if(contains_lowercase.value) passStrength.value += 1
  if(contains_special_character.value) passStrength.value += 1

  console.log('Pass Strength : ', passStrength.value)
}
</script>

