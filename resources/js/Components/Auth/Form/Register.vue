<template>
  <div class="mt-4">
    <h1 class="font-normal mb-0">
      Register Account
    </h1>
    <p>Please fill-out some informations for your account</p>
    <form class="mt-3" @submit.prevent="register">
      <FormInput id="fullname" v-model="registrationForm.name" label="Full Name" :error="registrationForm.errors.name" required />
      <FormInput id="email" v-model="registrationForm.email" type="email" label="Email Address" :error="registrationForm.errors.email" required />
      <FormInput id="password" v-model="registrationForm.password" :type="showPass.password ? 'text' : 'password'" label="Password" :error="registrationForm.errors.password" required @input="checkPassword">
        <template #icon-right>
          <component :is="showPass.password ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.password = !showPass.password" />
        </template>
      </FormInput>
      <FormInput id="confirm_password" v-model="registrationForm.password_confirmation" :type="showPass.confirm ? 'text' : 'password'" label="Confirm Password" required>
        <template #icon-right>
          <component :is="showPass.confirm ? EyeSlashIcon : EyeIcon" class="text-gray-400 w-5 h-5 cursor-pointer hover:text-gray-500 duration-200 ease-out" @click.prevent="showPass.confirm = !showPass.confirm" />
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
      <div class="flex mx-2 mt-3">
        <input 
          id="newsLetterSubscription"
          v-model="registrationForm.newsletter_subscription" 
          type="checkbox" 
          class="accent-theme-green w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
        <label for="newsLetterSubscription" class="ml-2 text-sm font-medium text-gray-700">Signup for newsletter</label>
      </div>
      <div class="flex mx-2 mt-1">
        <input 
          id="appNotificationSubscription"
          v-model="registrationForm.app_notifications_subscription" 
          type="checkbox" 
          class="accent-theme-green w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
        <label for="appNotificationSubscription" class="ml-2 text-sm font-medium text-gray-700">Signup for app notifications</label>
      </div>
      <!-- <label for="">Password strength indicator:</label>
      <div class="input_container">
        <ul class="flex items-stretch flex-col">
          <li :class="{ is_valid: contains_eight_characters }">
            8 Characters
          </li>
          <li :class="{ is_valid: contains_number }">
            Contains Number
          </li>
          <li :class="{ is_valid: contains_uppercase }">
            Contains Uppercase
          </li>
          <li :class="{ is_valid: contains_lowercase }">
            Contains Lowercase
          </li>
          <li :class="{ is_valid: contains_special_character }">
            Contains Special Character
          </li>
        </ul>
      </div> -->
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

const props = defineProps({
  errors: Object,
  redirectTo: String
})

const registrationForm = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
  newsletter_subscription: false,
  app_notifications_subscription: false,
  redirectTo: props.redirectTo
})

const showPass = reactive({
  password: false,
  confirm: false
})

const loading = ref(false)
const password_length = ref(0)
const contains_eight_characters = ref(false)
const contains_number = ref(false)
const contains_uppercase = ref(false)
const contains_lowercase = ref(false)
const contains_special_character = ref(false)
const passStrength = ref(0)

const register = () => {
  loading.value = true
  registrationForm.post(route('register'), {
    onFinish: () => {
      [ 
        registrationForm.reset('password'),
        registrationForm.reset('password_confirmation')
      ]
      loading.value = false
    }
  })
}

const checkPassword = () => {
  password_length.value = registrationForm.password.length
  const format = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/ // eslint-disable-line no-undef
			
  contains_eight_characters.value = password_length.value > 8
  contains_number.value = /\d/.test(registrationForm.password)
  contains_uppercase.value = /[A-Z]/.test(registrationForm.password)
  contains_lowercase.value = /[a-z]/.test(registrationForm.password)
  contains_special_character.value = format.test(registrationForm.password)

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
<style scoped>
ul {
	padding-left: 20px;
	display: flex;
	flex-direction: column;
	align-items: flex-start;
}
li { 
	color: #525f7f;
	position: relative;
  list-style-type: disc;
}
li:before {
  content: "";
	width: 0%; height: 2px;
	background: #2ecc71;
	position: absolute;
	left: 0; top: 50%;
	display: block;
	transition: all .6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
/* Checkmark & Strikethrough --------- */

.is_valid { color: rgba(136, 152, 170, 0.8); }
.is_valid:before { width: 100%; }

.checkmark_container {
	border-radius: 50%;
	position: absolute;
	top: -15px; right: -15px;
	background: #2ecc71;
	width: 50px; height: 50px;
	visibility: hidden;
	opacity: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	transition: opacity .4s ease;
}

.show_checkmark {
  visibility: visible;
  opacity: 1;
}

.checkmark {
  width: 100%;
  height: 100%;
  fill: none;
  stroke: white;
  stroke-width: 15;
  stroke-linecap: round;
  stroke-dasharray: 180;
  stroke-dashoffset: 180;
}

.checked { animation: draw 0.5s ease forwards; }

@keyframes draw {
  to { stroke-dashoffset: 0; }
}
</style>
