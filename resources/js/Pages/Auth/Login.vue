<template>
  <AuthLayout>
    <LoginForm />
    <Modal v-model="modalShown" class="relative">
      <div class="update-icon-div md:w-2/12 w-1/12">
        <WrenchScrewdriverIcon class="text-green-700 animate-bounce" />
      </div>
      <div class="py-2">
        <div class="flex justify-between gap-x-12">
          <h1 class=" text-green-700 font-bold dark:text-green-500">
            ABOUT UPDATE
          </h1>
          <h1 class="text-green-700 font-bold dark:text-green-500">
            V{{ version }}
          </h1>
        </div>
        <ol type="1">
          <li v-for="list in lists" :key="list.id" class="font-medium mt-1 dark:text-gray-200 text-gray-700">
            {{ list.description }}
          </li>
        </ol>
        <hr class="border-dashed mt-4" />
        <div class="mt-3">
          <h5 class="italic text-green-700 font-bold dark:text-green-500">
            How to update:
          </h5>
          <ol>
            <li class="text-xs italic mt-1 dark:text-gray-200 text-gray-700">
              Click the update button.
            </li>
            <li class="text-xs italic mt-1 dark:text-gray-200 text-gray-700">
              After successful update close the application.
            </li>
            <li class="text-xs italic mt-1 dark:text-gray-200 text-gray-700">
              Reopen the application to get the latest version of the application.
            </li>
          </ol>        
        </div>
        <form class="mt-3">
          <div class="w-full mt-3">
            <ProgressBar v-if="showProgressBar" :duration="60" />
            <Button v-else :loading="loading" label="Update" color="success" class="w-full" @click.prevent="update" />
          </div>
        </form>
      </div>
    </Modal>
  </AuthLayout>
</template>
<script setup>
import { ref } from 'vue'
import AuthLayout from '../../Layouts/Auth.vue'
import LoginForm from '../../Components/Auth/Form/Login.vue'
import Modal from '../../Components/AppUpdateModal.vue'
import Button from '../../Components/Button.vue'
import { WrenchScrewdriverIcon } from '@heroicons/vue/24/solid'
import ProgressBar from '../../Components/ProgressBar.vue'

const user_id = localStorage.getItem('userId')
const modalShown = ref(false)
const loading = ref(false)
const showProgressBar = ref(false)
const lists = ref('')
const version = ref('')

const startProgressBar = () => {
  showProgressBar.value = true
}
fetch('/api/user/' + user_id)
  .then(res => res.json())
  .then(data => {
    if(data.status){
      modalShown.value = true
      lists.value = data.list
      version.value = data.version_number
    }else{
      return
    }
  })
const update = () => {
  fetch('/api/user/update_trigger/' + user_id)
    .then(res => res.json())
    .then(data => {
      if(data.status){
        startProgressBar()
      }
    })
}

</script>
<style scoped>
ol{
  list-style-type: decimal;
  list-style-position: inside;
}
.update-icon-div{
  justify-content: center;
  align-items: center;
  text-align: center;
  margin-top: -15%;
  margin-left: 43%;
  background-color: #fff;
  border-radius: 100px;
  padding: 14px;
}
</style>