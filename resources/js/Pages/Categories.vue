<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg">
    <Head title="Categories" />
    <!-- <p>{{ activeCategory }}</p> -->
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
            <div v-for="category in categoryType" :key="category.id" class="relative bg-white hover:bg-gray-100 active:bg-gray-200 duration-200 ease-out w-96 rounded-md shadow px-4 py-4 cursor-pointer" @click.prevent="toggleSwitchCategory(category)">
              <div v-if="category.id === activeCategory" class="absolute right-3 top-3">
                <CheckCircleIcon class="w-6 text-green-600" />
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
  </AuthenticatedLayout> 
</template>
<script setup>
import { ref } from 'vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import { Head, router } from '@inertiajs/vue3'

import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'

defineProps({
  categories: Object,
  activeCategory: [Object, Number]
})

const selectedCategory = ref('')
const setCategoryModal = ref(false)

const toggleSwitchCategory = (category) => {
  setCategoryModal.value = true
  selectedCategory.value = category
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