<template>
  <AuthLayout>
    <div
      class=""
    >
      <div class="lg:h-screen md:w-full md:rounded-none opacity-95 md:relative md:opacity-1  md:mt-0 sm:w-md xl:p-0 dark:border-gray-700 lg:flex lg:items-center lg:justify-center lg:flex-col">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:">
            Sign up
          </h1>
          <form class="space-y-4 md:space-y-6" @submit.prevent="registrationForm.post(route('post.register'))">
            <div>
              <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900 dark:">Name</label>
              <input id="firstname" v-model="registrationForm.name" type="text" name="name" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g John" required="">
            </div>
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:">Email</label>
              <input id="email" v-model="registrationForm.email" type="email" name="email" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
              <div v-if="errors.email" class="text-red-60">
                {{ errors.email }}
              </div>
            </div>
            <div class="relative">
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:">Password</label>
              <input v-if="!show_pass" id="password" v-model="registrationForm.password" type="password" name="password" placeholder="••••••••" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              <input v-else id="password" v-model="registrationForm.password" type="text" name="password" placeholder="••••••••" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              <font-awesome-icon v-if="!show_pass" icon="fa-solid fa-eye-slash" class="absolute top-11 right-4  cursor-pointer" @click="showPass" />
              <font-awesome-icon v-else icon="fa-solid fa-eye" class="absolute top-11 right-4  cursor-pointer" @click="showPass" />
            </div>
            <div class="relative">
              <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:">Confirm Password</label>
              <input v-if="!show_conf_pass" id="confirm_password" v-model="registrationForm.password_confirmation" type="password" name="confirm_password" placeholder="••••••••" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              <input v-else id="confirm_password" v-model="registrationForm.password_confirmation" type="text" name="confirm_password" placeholder="••••••••" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              <font-awesome-icon v-if="!show_conf_pass" icon="fa-solid fa-eye-slash" class="absolute top-11 right-4 " @click="showConfPass" />
              <font-awesome-icon v-else icon="fa-solid fa-eye" class="absolute top-11 right-4 " @click="showConfPass" />
            </div>
            <button v-if="!loader" type="submit" class="sign-up-button bg-blue-700 w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
              Register
            </button>
            <button v-else class="bg-blue-700 w-full  bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
              <Spinner />
              Loading
            </button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Already have an account? 
              <!-- <router-link :to="{name: 'Login'}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                  Sign in
                </router-link> -->
              <links :href="route('login')" class="font-bold text-primary-600 hover:underline dark:text-primary-500">
                Sign in
              </links>
            </p>
          </form>
        </div>
      </div>
    </div>
  </AuthLayout>
</template>
<script>
import { Link as links } from "@inertiajs/vue3"
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
      registrationForm: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
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
  }
}
</script>
<style scoped>
.sign-up-button{
  width:500px!important;
  min-width:500px!important;
}
</style>