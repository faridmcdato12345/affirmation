<template>
  <section class="md:h-screen">
    <div class="md:h-full">
      <!-- Left column container with background-->
      <div
        class="g-6 flex lg:flex-col h-full flex-wrap w-full items-center justify-center lg:justify-between"
      >
        <Logo />
        <!-- Right column container -->
        <div class="lg:h-screen w-3/4 md:w-full md:rounded-none absolute opacity-95 md:relative md:opacity-1 bg-white rounded-lg shadow dark:border md:mt-0 sm:w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 lg:w-6/12 lg:flex lg:items-center lg:justify-center">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              Sign up
            </h1>
            <form class="space-y-4 md:space-y-6" @submit.prevent="registerUser">
              <div>
                <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Firstname</label>
                <input id="firstname" v-model="form.firstname" type="text" name="firstname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g John" required="">
              </div>
              <div>
                <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lastname</label>
                <input id="lastname" v-model="form.lastname" type="lastname" name="lastname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g Doe" required="">
              </div>
              <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input id="email" v-model="form.email" type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
              </div>
              <div class="relative">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input v-if="!show_pass" id="password" v-model="form.password" type="password" name="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                <input v-else id="password" v-model="form.password" type="text" name="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                <font-awesome-icon v-if="!show_pass" icon="fa-solid fa-eye-slash" class="absolute top-11 right-4 text-white cursor-pointer" @click="showPass" />
                <font-awesome-icon v-else icon="fa-solid fa-eye" class="absolute top-11 right-4 text-white cursor-pointer" @click="showPass" />
              </div>
              <div class="relative">
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                <input v-if="!show_conf_pass" id="confirm_password" v-model="conf_pass" type="password" name="confirm_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                <input v-else id="confirm_password" v-model="conf_pass" type="text" name="confirm_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                <font-awesome-icon v-if="!show_conf_pass" icon="fa-solid fa-eye-slash" class="absolute top-11 right-4 text-white" @click="showConfPass" />
                <font-awesome-icon v-else icon="fa-solid fa-eye" class="absolute top-11 right-4 text-white" @click="showConfPass" />
              </div>
              <button v-if="!loader" type="submit" class="bg-blue-700 w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Sign in
              </button>
              <button v-else class="bg-blue-700 w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <Spinner />
                Loading
              </button>
              <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Already have an account? 
                <!-- <router-link :to="{name: 'Login'}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                  Sign in
                </router-link> -->
                <links :href="route('login')">
                  Sign in
                </links>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { Link as links } from "@inertiajs/vue3"
import axios from "axios"
export default {
  components: {
    links
  },
  data(){
    return {
      form: {
        email: "",
        password: "",
        firstname: "",
        lastname: ""
      },
      show_pass: false,
      show_conf_pass: false,
      conf_pass: "",
      loader: false
    }
  },
  methods: {
    registerUser(){
      this.loader = true
      if(this.form.password == this.conf_pass){
        axios.post("/auth/register", this.form)
          .then(response => {
            this.loader = false
            localStorage.setItem("access-token",response.data.access_token.original.access_token)
            this.$router.push({name: "Home"})
          })
          .catch(error => console.log(error))
      }
    },
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

</style>