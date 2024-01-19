<template>
  <div tabindex="0" class="relative flex justify-between px-3 py-3 border dark:border-gray-500 rounded-sm my-2">
    <div>
      <p v-if="!isEdit" class="dark:text-white text-base text-black font-medium max-w-[45ch]" @click.prevent="isEdit = true">
        {{ affirmation }}
      </p>
      <FormInput v-else :id="id" autofocus label="Update affirmation" :model-value="affirmation" class="w-[400px]" @update:model-value="logUpdate" @keyup-enter="updateAffirmation" @blur="isEdit = false" />
      <p class="text-xs text-gray-500 dark:text-gray-300">
        {{ date }}
      </p>
    </div>
    <div class="absolute top-1/2 -translate-y-1/2 right-4 flex gap-x-1">
      <TrashIcon class="w-4 text-gray-500 hover:text-red-600 cursor-pointer" @click.prevent="emit('delete')" />
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import FormInput from '../../FormInput.vue'
import { TrashIcon } from '@heroicons/vue/24/solid'

const isEdit = ref(false)
const updatedText = ref()

const props = defineProps({
  id: {
    type: [String, Number],
    required: true
  },
  affirmation: {
    type: String,
    required: true
  },
  date: {
    type: [String, Date],
    required: true
  }
})

const emit = defineEmits(['delete'])

const updateAffirmation = () => {
  isEdit.value = false
  router.put(route('user-affirmation.update', props.id), {
    text: updatedText.value
  })
}

const logUpdate = (data) => {
  updatedText.value = data
}
</script>
