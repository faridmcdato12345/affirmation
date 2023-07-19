<template>
  <AuthenticatedLayout>
    <Head title="Themes" />
    <div class="h-screen w-full bg-gray-900/60 fixed top-0"></div>
    <div class="z-20 md:max-w-7xl mx-auto relative flex flex-col h-screen px-4 md:pb-0">
      <h1 class="text-white text-3xl mt-24 md:mt-12 text-center">
        Background Image
      </h1>
      <h2 class="text-white font-medium text-2xl mt-8">
        System Background
      </h2>
      <hr class="my-5 border-gray-600" />
      <div class="flex flex-wrap gap-2 items-stretch">
        <div v-for="img in images" :key="img" class="relative w-[400px] h-[200px] rounded-md border border-gray-800 object-cover items-stretch hover:-translate-y-1 cursor-pointer ease-out duration-150" @click.prevent="toggleSwitchBackground(img)">
          <CheckCircleIcon v-if="bgImage === img" class="w-7 text-green-600 absolute top-2 right-3 z-20" />
          <img :src="img" alt="Background Image" class="object-cover w-full h-full rounded-md brightness-75 hover:brightness-100" />
        </div>
      </div>
      <div class="relative md:hidden h-72 w-full"></div>
    </div>

    <!-- SWITCH CATEGORY MODAL -->
    <Modal v-model="switchBackgroundModal">
      <div class="text-center">
        <CheckCircleIcon class="w-14 mx-auto text-green-600" />
        <h1 class="mt-2">
          Change Background
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light">
          Are you sure you want to switch your current background image to this? You can still switch back if you'd like to. 
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" color="gray" @click.prevent="switchBackgroundModal = false" />
        <Button label="Switch Background" color="success" @click.prevent="switchBackground" />
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { computed, ref } from 'vue'
import { Head, usePage, router } from '@inertiajs/vue3'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'

const page = usePage()
const bgImage = computed(() => page.props.auth.user.background_image ?? '/images/bg1.jpg')

const switchBackgroundModal = ref(false)
const selectedImage = ref('')

const images = [
  '/images/bg1.jpg', 
  '/images/bg2.jpg', 
  '/images/bg3.jpg',
  '/images/bg4.jpg',
  '/images/bg5.jpg',
  '/images/bg6.jpg',
  '/images/bg7.jpg',
  '/images/bg8.jpg',
]

const toggleSwitchBackground = (data) => {
  switchBackgroundModal.value = !switchBackgroundModal.value
  selectedImage.value = data
}

const switchBackground = () => {
  console.log('Switching to: ', selectedImage.value)
  router.put(`user/${page.props.auth.user.id}/switch-background`, {
    img: selectedImage.value
  }, {
    onSuccess: () => {
      switchBackgroundModal.value = false
    },
    onError: () => {
      console.log('Something went wrong!')
    }
  })
}
</script>
