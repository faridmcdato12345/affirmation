<template>
  <AuthenticatedLayout>
    <Head title="Themes" />
    <div class="h-screen w-full bg-gray-900/60 fixed top-0"></div>
    <div class="z-20 md:max-w-7xl w-full mx-auto relative flex flex-col h-screen px-6 pb-12 md:pb-0">
      <h1 class="text-white text-3xl mt-24 md:mt-12 text-center dark:text-white">
        Background Image
      </h1>
      <h2 class="text-white font-medium text-2xl mt-8 dark:text-gray-300">
        My Backgrounds
      </h2>
      <hr class="my-5 border-gray-600" />
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div v-for="img in backgroundImages" :key="img" class="relative w-full h-[160px] md:h-[200px] rounded-md border border-gray-200/30 object-cover items-stretch hover:-translate-y-1 cursor-pointer ease-out duration-150" @click.prevent="toggleSwitchBackground(img.image)">
          <TrashIcon class="w-6 md:w-6 absolute top-2 right-3 z-20 text-white" @click.stop="toggleDeleteBackground(img)" />
          <CheckCircleIcon v-if="bgImage === img.image" class="w-6 md:w-7 text-green-600 absolute top-2 left-3 z-20" />
          <img :src="img.image" alt="Background Image" class="object-cover w-full h-full rounded-md brightness-75 hover:brightness-100" />
        </div>
        <div class="bg-white dark:bg-gray-800 dark:border dark:border-gray-600 relative h-fit hover:-translate-y-1 active:bg-gray-200 duration-200 ease-out w-full rounded-md shadow px-5 py-6 cursor-pointer" @click.stop="triggerUpload">
          <div class="absolute top-3 right-3">
            <PlusCircleIcon class="w-6 text-green-600 hover:text-green-700" />
          </div>
          <h3 class="font-medium dark:text-white">
            Upload Image
          </h3>
          <p class="dark:text-gray-300 text-gray-600 text-sm mt-3">
            Click to upload your own background image. You can add up to 10 images only.
          </p>
          <input id="imageUpload" ref="imageUploadRef" type="file" name="imageUpload" class="hidden" @change="onSelect" />
        </div> 
      </div>
      <h2 class="text-white font-medium text-2xl mt-8">
        System Background
      </h2>
      <hr class="my-5 border-gray-600" />
      <div class="w-full items-stretch pb-24 md:pb-40 grid grid-cols-1 md:grid-cols-3 gap-3">
        <div v-for="img in images" :key="img" class="relative w-full h-[160px] md:h-[200px] rounded-md border border-gray-200/30 object-cover items-stretch hover:-translate-y-1 cursor-pointer ease-out duration-150" @click.prevent="toggleSwitchBackground(img)">
          <CheckCircleIcon v-if="bgImage === img" class="w-6 md:w-7 text-green-600 absolute top-2 right-3 z-20" />
          <img :src="img" alt="Background Image" class="object-cover w-full h-full rounded-md brightness-75 hover:brightness-100" />
        </div>
      </div>
    </div>

    <!-- DELETE BACKGROUND MODAL -->
    <Modal v-model="deleteBackgroundModal">
      <div class="text-center">
        <TrashIcon class="w-8 md:w-10 mx-auto text-red-600" />
        <h1 class="mt-2 dark:text-white">
          Delete Background
        </h1>
        <p class="dark:text-gray-300 text-sm md:text-base max-w-md mx-auto leading-6 mt-2 font-light">
          Are you sure you want to remove this background?
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" :disabled="loading" color="gray" @click.prevent="deleteBackgroundModal = false" />
        <Button label="Delete" :loading="loading" color="error" @click.prevent="deleteBackground" />
      </div>
    </Modal>

    <!-- SWITCH BACKGROUND MODAL -->
    <Modal v-model="switchBackgroundModal">
      <div class="text-center">
        <CheckCircleIcon class="w-10 md:w-14 mx-auto text-green-600" />
        <h1 class="mt-2 dark:text-white">
          Change Background
        </h1>
        <p class="dark:text-gray-300 text-sm md:text-base max-w-md mx-auto leading-6 mt-2 font-light">
          Are you sure you want to switch your current background image to this? You can still switch back if you'd like to. 
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" color="gray" @click.prevent="switchBackgroundModal = false" />
        <Button label="Switch Background" color="success" @click.prevent="switchBackground" />
      </div>
    </Modal>

    <!-- UPGRADE MODAL -->
    <Modal v-model="upgradeModal">
      <div class="py-2 flex gap-x-5">
        <LockClosedIcon class="w-10 mx-auto text-gray-400" />
        <div>
          <h1 class="mt-2 dark:text-white">
            Subscribe to Premium
          </h1>
          <p class="dark:text-gray-200 text-base max-w-md mx-auto leading-6 mt-2 font-light">
            Gain access to our premium categories, exclusive contents and exciting features within our app.
          </p>
        </div>
      </div>
      <div class="flex items-center justify-end gap-x-2 mt-4">
        <Button label="Cancel" color="gray" component-type="link" @click.prevent="upgradeModal = false" />
        <Button component-type="link" href="/settings/subscribe" label="Subscribe to Premium" color="success" />
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import { computed, ref } from 'vue'
import { Head, usePage, router, useForm } from '@inertiajs/vue3'
import { CheckCircleIcon, PlusCircleIcon, TrashIcon, LockClosedIcon } from '@heroicons/vue/24/solid'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import { toast } from '../Composables/useToast'
import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'


const props = defineProps({
  backgroundImages: {
    type: Object,
    default: () => {}
  },
  isPremium: {
    type: [String, Boolean],
    default: false 
  }
})

const page = usePage()
const bgImage = computed(() => page.props.auth.user.background_image ?? '/images/bg1.jpg')

const loading = ref(false)
const selectedImage = ref('')
const imageUploadRef = ref('')
const upgradeModal = ref(false)
const form = useForm({ image: null })
const switchBackgroundModal = ref(false)
const deleteBackgroundModal = ref(false)

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

const triggerUpload = () => { 
  if(!props.isPremium) {
    upgradeModal.value = true 
    return 
  }
  imageUploadRef.value.click()
}

const onSelect = (e) => {
  if (e.target.files && e.target.files[0]) {
    const maxAllowedSize = 8 * 1024 * 1024
    if (e.target.files[0].size > maxAllowedSize) {
      e.target.value = ''
      return toast.error('Sorry! Image size limit is 8mb only.')
    }
  }
  
  form.image = e.target.files[0]
  uploadImage()
}

const toggleDeleteBackground = (img) => {
  selectedImage.value = img.id 
  deleteBackgroundModal.value = true
}

const deleteBackground = () => {
  loading.value = true 
  router.delete(route('themes.delete', selectedImage.value), {
    onSuccess: () => {
      toast('Background has been deleted successfully!')
      deleteBackgroundModal.value = false 
    },
    onError: () => {
      toast.error('Something went wrong. Please try again')
    },
    onFinish: () => {
      setTimeout(() => {
        loading.value = false
      }, 200)
    }
  }) 
}

const switchBackground = () => {
  router.put(`user/${page.props.auth.user.id}/switch-background`, {
    img: selectedImage.value
  }, {
    onSuccess: () => {
      switchBackgroundModal.value = false
    },
    onError: () => {
      toast.error('Something went wrong. Please try again!')
    }
  })
}

const uploadImage = () => {
  form.post(route('themes.image-upload'), {
    onSuccess: () => toast.success('Image has been uploaded successfully!'),
    onError: () => toast.error('Invalid image selected. Please try again'),
  })
}
</script>
