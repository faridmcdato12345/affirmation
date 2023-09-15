<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg" class="">
    <Head title="Categories" />
    <div class="h-screen w-full bg-gray-900/60 fixed top-0"></div>
    <div class="h-screen w-full flex flex-col px-6 md:max-w-7xl mx-auto z-20 relative">
      <h1 class="text-white text-3xl mt-20 text-center">
        Categories
      </h1>
      <div class="flex flex-col w-full pb-2">
        <h2 class="text-white font-medium text-2xl mt-8">
          My Categories
        </h2>
        <hr class="my-5 border-gray-600" />
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div
            v-for="myCategory in myCategories"
            :key="myCategory.id"
            class="bg-white dark:bg-gray-800 dark:border-gray-600 relative hover:-translate-y-1 active:bg-gray-200 duration-200 ease-out w-full rounded-md shadow px-5 py-6 cursor-pointer"
            @click.prevent="toggleSwitchCategory(myCategory, 'personal')">
            <div class="absolute bottom-3 right-3 gap-x-1 flex">
              <EyeIcon class="w-5 text-gray-500 hover:text-green-600" @click.stop="toggleAffirmation(myCategory)" />
              <PencilSquareIcon class="w-5 text-gray-500 hover:text-green-600" @click.stop="toggleModal('update', myCategory)" />
              <TrashIcon class="w-5 text-gray-500 hover:text-red-600" @click.stop="toggleModal('delete', myCategory)" />
            </div>
            <div class="absolute top-3 right-3">
              <CheckCircleIcon v-if="myCategory.id === activeCategory && activeCategoryType === 'App\\Models\\UserCategories'" class="w-7 text-green-600 " />
            </div>
            <h3 class="font-medium dark:text-white">
              {{ myCategory.text }}
            </h3>
            <p class="text-gray-600 text-sm dark:text-gray-300">
              {{ myCategory.blurb }}
            </p>
          </div>
          <div class="bg-white dark:bg-gray-800 dark:border-gray-600 dark:border relative hover:-translate-y-1 active:bg-gray-200 duration-200 ease-out w-full rounded-md shadow px-5 py-6 cursor-pointer" @click.prevent="addCategoryModal = true">
            <div class="absolute top-3 right-3">
              <PlusCircleIcon class="w-6 text-green-600 hover:text-green-700" />
            </div>
            <h3 class="font-medium dark:text-white">
              Add Category
            </h3>
            <p class="text-gray-600 text-sm dark:text-gray-300">
              Add your own category for your own affirmations
            </p>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-full pb-40">
        <div v-for="(categoryType, i) in categories" :key="`${i}-category`">
          <h2 class="text-white font-medium text-2xl mt-8">
            {{ i == 0 ? 'Free' : 'Premium' }}
          </h2>
          <hr class="my-5 border-gray-600" />
          <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div
              v-for="category in categoryType"
              :key="category.id"
              class="relative hover:-translate-y-1 active:bg-gray-200 duration-200 ease-out w-full rounded-md shadow px-5 py-6 cursor-pointer"
              :class="[
                i == 0 || isPremium ? 'bg-white dark:bg-gray-800 dark:border-gray-600 dark:border' : 'bg-gray-200 dark:bg-gray-800 dark:border dark:border-gray-600'
              ]"
              @click.prevent="toggleSwitchCategory(category)">
              <div v-if="category.id === activeCategory && activeCategoryType === 'App\\Models\\Category'" class="absolute right-3 top-3">
                <CheckCircleIcon class="w-6 text-green-600" />
              </div>
              <div v-if="!isPremium && i != 0" class="absolute right-3 top-3">
                <LockClosedIcon class="w-6 " />
              </div>
              <div class="min-h-[100px]">
                <h3 class="font-medium dark:text-white">
                  {{ category.text }}
                </h3>
                <p class="text-gray-600 text-sm dark:text-gray-300 mb-6">
                  {{ category.blurb }}
                </p>
              </div>
              
              <div class="absolute bottom-[0.5rem] w-full pr-8">
                <div class="flex justify-between">
                  <div>
                    <p class="text-gray-600 text-sm dark:text-gray-300">
                      <span v-if="category.affirmations.length != category.affirmations_count">Progress: </span>
                      <span v-else>Completed: </span>
                      <span :class="category.affirmations.length != category.affirmations_count ? 'text-gray-600' : 'text-green-600'">
                        {{ category.affirmations ? category.affirmations.length : 0 }}
                      </span>
                      <span>/</span>
                      <span class="text-green-600">{{ category.affirmations_count }}</span>
                    </p>
                  </div>
                  <div v-if="category.affirmations.length == category.affirmations_count" class="w-[5%]">
                    <ArrowPathIcon @click.stop="refreshCategory(category)" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SWITCH CATEGORY MODAL -->
    <Modal v-model="infoSwitchModal">
      <div class="text-center">
        <XCircleIcon class="w-14 mx-auto text-red-600" />
        <h1 class="mt-2 dark:text-white">
          No Affirmations Found
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-300">
          Please add atleast one affirmation to your category before switching it as active.
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Close" btn-block color="gray" @click.prevent="infoSwitchModal = false" />
      </div>
    </Modal>

    <!-- SWITCH CATEGORY MODAL -->
    <Modal v-model="setCategoryModal">
      <div class="text-center">
        <CheckCircleIcon class="w-14 mx-auto text-green-600" />
        <h1 class="mt-2 dark:text-white">
          {{ selectedCategory.text }}
        </h1>
        <p class="dark:text-gray-300 text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          {{ selectedCategory.blurb }}
        </p>
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" color="gray" @click.prevent="setCategoryModal = false" />
        <Button label="Switch Category" color="success" @click.prevent="switchCategory" />
      </div>
    </Modal>

    <!-- UPGRADE MODAL -->
    <Modal v-model="upgradeModal">
      <div class="py-2 flex">
        <LockClosedIcon class="w-14 mx-auto text-gray-400" />
        <div>
          <h1 class="mt-2 dark:text-white">
            Subscribe to Premium
          </h1>
          <p class="dark:text-gray-400 text-base max-w-md mx-auto leading-6 mt-2 font-light">
            Gain access to our premium categories, exclusive contents and exciting features within our app.
          </p>
        </div>
      </div>
      <div class="flex items-center justify-end gap-x-2 mt-4">
        <Button label="Cancel" color="gray" component-type="link" @click.prevent="upgradeModal = false" />
        <Button component-type="link" href="/billing" label="Subscribe for Access" color="success" />
      </div>
    </Modal>

    <Affirmation v-model="showAffirmationModal" :affirmations="selectedCateg?.affirmations" @add-affirmation="addAffirmation" />
    <AddAffirmation v-model="addAffirmationModal" :category="selectedCateg" :errors="errors" />

    <AddCategory v-model="addCategoryModal" />
    <UpdateCategory v-model="updateCategoryModal" :category="selectedCateg" />
    <DeleteCategory v-model="deleteCategoryModal" :category="selectedCateg?.text" :category-id="selectedCateg?.id" />
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, watch } from 'vue'
import { CheckCircleIcon, EyeIcon, LockClosedIcon, PencilSquareIcon, PlusCircleIcon, TrashIcon, XCircleIcon,ArrowPathIcon } from '@heroicons/vue/24/solid'
import { Head, router } from '@inertiajs/vue3'
import { toast } from '../Composables/useToast'

import AddAffirmation from '../Components/Category/Affirmation/AddAffirmation.vue'


import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Affirmation from '../Components/Category/Affirmation/Affirmations.vue'
import AddCategory from '../Components/Category/AddCategory.vue'
import UpdateCategory from '../Components/Category/UpdateCategory.vue'
import DeleteCategory from '../Components/Category/DeleteCategory.vue'

import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'

const props = defineProps({
  categories: Object,
  activeCategory: [Object, Number],
  isPremium: Boolean,
  myCategories: Object,
  activeCategoryType: String,
  errors: Object
})
console.log('category props: ',props.categories)
const selectedCategory = ref('')
const setCategoryModal = ref(false)
const upgradeModal = ref(false)
const addCategoryModal = ref(false)
const updateCategoryModal = ref(false)
const infoSwitchModal = ref(false)
const deleteCategoryModal = ref(false)

//Passed on the update and delete modal
const selectedCateg = ref({})

//Added as argument when updating active category
const selectedCategoryType = ref('')

const toggleModal = (type, category) => {
  selectedCateg.value = category
  type === 'delete' ? deleteCategoryModal.value = true : updateCategoryModal.value = true
}

const toggleSwitchCategory = (category, categoryType = '') => {
  if(props.isPremium || categoryType === 'personal' || !category.premium) {

    //Set the selectedCategoryType to true
    if(categoryType == 'personal') {
      selectedCategoryType.value = 'personal'

      if(category.affirmations.length == 0) {
        return infoSwitchModal.value = true
      }
    }

    setCategoryModal.value = true
    selectedCategory.value = category

  } else {
    upgradeModal.value = true
  }
}

const switchCategory = async () => {
  router.post(route('setCategory'), { // eslint-disable-line no-undef
    category_id: selectedCategory.value.id,
    type: selectedCategoryType.value
  }, {
    onSuccess: () => {
      selectedCategory.value = ''
      setCategoryModal.value = false
      selectedCategoryType.value = ''
    },
  }
  )
}
const refreshCategory = (category) => {
  selectedCategory.value = category
  router.put(route('category.refresh',selectedCategory.value.id),{
    onSuccess: (response) => {
      console.log('reponse: ',response)
      toast.success('Status has been updated!')
    },
    onFinish: () => {
      console.log('success aki')
    }
  })
}
/**
 *  Affirmation
 */
const showAffirmationModal = ref(false)
const addAffirmationModal = ref(false)
// const deleteAffirmationModal = ref(false)

const toggleAffirmation = (category) => {
  showAffirmationModal.value = true
  selectedCateg.value = category
}

const addAffirmation = () => {
  showAffirmationModal.value = false
  addAffirmationModal.value = true
}

watch([() => addAffirmationModal.value], ([addVal]) => {
  if(!addVal) {
    showAffirmationModal.value = true
  }
})

watch(() => props.myCategories, () => {
  selectedCateg.value = props.myCategories.filter(category => category.id === selectedCateg.value?.id)[0]
})

</script>
