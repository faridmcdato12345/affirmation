<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg">
    <Head title="Categories" />
    <div class="h-screen w-full bg-gray-900/60 fixed top-0"></div>
    <div class="h-screen flex flex-col px-4 md:max-w-7xl mx-auto z-20 relative">
      <h1 class="text-white text-3xl mt-8 text-center">
        Categories
      </h1>
      <div class="flex flex-col w-full pb-40">
        <div v-for="(categoryType, i) in categories" :key="`${i}-category`">
          <h2 class="text-white font-medium text-2xl mt-8">
            {{ i == 0 ? 'Free' : 'Premium' }}
          </h2>
          <hr />
          <div class="flex gap-4 flex-wrap">
            <div 
              v-for="category in categoryType" 
              :key="category.id" 
              class="relative hover:-translate-y-1 active:bg-gray-200 duration-200 ease-out w-96 rounded-md shadow px-4 py-4 cursor-pointer"
              :class="[
                i == 0 || isPremium ? 'bg-white' : 'bg-gray-200'
              ]" 
              @click.prevent="toggleSwitchCategory(category)">
              <div v-if="category.id === activeCategory" class="absolute right-3 top-3">
                <CheckCircleIcon class="w-6 text-green-600" />
              </div>
              <div v-if="!isPremium && i != 0" class="absolute right-3 top-3">
                <LockClosedIcon class="w-6 " />
              </div>
              <h3 class="font-medium">
                {{ category.text }}
              </h3>
              <p class="text-gray-600 text-sm">
                {{ category.blurb }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SWITCH CATEGORY MODAL -->
    <Modal v-model="setCategoryModal">
      <div class="text-center">
        <CheckCircleIcon class="w-14 mx-auto text-green-600" />
        <h1 class="mt-2">
          {{ selectedCategory.text }}
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          {{ selectedCategory.blurb }}
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" color="error" @click.prevent="setCategoryModal = false" />
        <Button label="Switch Category" color="success" @click.prevent="switchCategory" />
      </div>
    </Modal>

    <!-- UPGRADE MODAL -->
    <Modal v-model="upgradeModal">
      <div class="py-2 flex">
        <LockClosedIcon class="w-14 mx-auto text-gray-400" />
        <div>
          <h1 class="mt-2">
            Subscribe to Premium
          </h1>
          <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light">
            Gain access to our premium categories, exclusive contents and exciting features within our app.
          </p>
        </div>
      </div>
      <div class="flex items-center justify-end gap-x-2 mt-4">
        <Button label="Cancel" color="error" @click.prevent="upgradeModal = false" />
        <Button component-type="link" href="/billing" label="Subscribe for Access" color="success" />
      </div>
    </Modal>
  </AuthenticatedLayout> 
</template>
<script setup>
import { ref } from 'vue'
import { CheckCircleIcon, LockClosedIcon } from '@heroicons/vue/24/solid'
import { Head, router } from '@inertiajs/vue3'

import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'

const props = defineProps({
  categories: Object,
  activeCategory: [Object, Number],
  isPremium: Boolean
})

const selectedCategory = ref('')
const setCategoryModal = ref(false)
const upgradeModal = ref(false)

const toggleSwitchCategory = (category) => {
  if(props.isPremium) {
    setCategoryModal.value = true
    selectedCategory.value = category
  } else {
    upgradeModal.value = true
  }
}

const switchCategory = async () => {
  router.post(route('setCategory'), { // eslint-disable-line no-undef
    category_id: selectedCategory.value.id
  }, {
    onSuccess: () => {
      selectedCategory.value = ''
      setCategoryModal.value = false
    }
  }
  )
}
</script>