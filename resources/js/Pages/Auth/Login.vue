<!-- eslint-disable vue/no-export-in-script-setup -->
<template>
  <AuthLayout>
    <div
      class=""
    > 
      <div class="lg:h-screen md:w-full md:rounded-none opacity-95 md:relative md:opacity-1  md:mt-0 sm:w-md xl:p-0 dark:border-gray-700 lg:flex lg:items-center lg:justify-center lg:flex-col">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
            Sign in to your account
          </h1>
          <form class="space-y-4 md:space-y-6" @submit.prevent="loginForm.post(route('post.login'))">
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
              <input id="email" v-model="loginForm.email" type="email" name="email" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="sample@sample.com" required="">
              <div v-if="errors.email" class="text-red-60">
                {{ errors.email }}
              </div>
            </div>
            <div class="relative">
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
              <input v-if="!show_pass" id="password" v-model="loginForm.password" type="password" name="password" placeholder="••••••••" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              <input v-else id="password" v-model="loginForm.password" type="text" name="password" placeholder="••••••••" class="bborder border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              <font-awesome-icon v-if="!show_pass" icon="fa-solid fa-eye-slash" class="absolute top-11 right-4 cursor-pointer" @click="showPass" />
              <font-awesome-icon v-else icon="fa-solid fa-eye" class="absolute top-11 right-4 cursor-pointer" @click="showPass" />
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded  focus:ring-3 focus:ring-primary-300  dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                </div>
              </div>
              <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
            </div>
            <button type="submit" class="sign-in-button bg-blue-700 w-full bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center text-white dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
              Sign in
            </button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Don’t have an account yet? <span><links :href="route('register')" class="font-bold text-primary-600 hover:underline dark:text-primary-500">
                Sign up
              </links></span>
            </p>
          </form>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>
<script>
import {Link as links
} from "@inertiajs/vue3"
import AuthLayout from "../../Layouts/Auth.vue"

export default {
  components: {
    links,
    AuthLayout
  },
  props: {
    errors: Object
  },
  data(){
    return{
      loginForm: {
        email: "",
        password: "",
        remember: false
      },
      show_pass: false,
      show_conf_pass: false,
      conf_pass: "",
      loader: false
    }
  },
  methods: {
    showPass(){
      this.show_pass = !this.show_pass
    },
    showConfPass(){
      this.show_conf_pass = !this.show_conf_pass
    }
  },
}
</script>
<style scoped>
.sign-in-button{
  width:500px!important;
  min-width:500px!important;
}
</style>