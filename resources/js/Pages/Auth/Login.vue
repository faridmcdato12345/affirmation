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
              Sign in to your account
            </h1>
            <form class="space-y-4 md:space-y-6" @submit.prevent="login">
              <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input id="email" v-model="form.email" type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
              </div>
              <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input id="password" v-model="form.password" type="password" name="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
              </div>
              <div class="flex items-center justify-between">
                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                  </div>
                  <div class="ml-3 text-sm">
                    <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                  </div>
                </div>
                <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
              </div>
              <button v-if="!loading" type="submit" class="bg-blue-700 w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Sign in
              </button>
              <button v-else class="bg-blue-700 w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                <Spinner />
                Loading
              </button>
              <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Don’t have an account yet? <router-link :to="{name: 'Register'}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
                  Sign up
                </router-link>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import axios from "axios"
// import Logo from "../components/Logo.vue"
// import Spinner from "./Spinner.vue"
export default {
  components: {
    // Logo,
    // Spinner
  },
  data(){
    return{
      form: {
        email: "",
        password: ""
      },
      loading: false
    }
  },
  methods: {
    login(){
      this.loading = true
      axios.post("/auth/login", this.form)
        .then(response => {
          this.loading = false
          localStorage.setItem("access-token",response.data.access_token)
          window.location = "/user"
        })
        .catch(error => console.log(error))
    }
  }
}
</script>