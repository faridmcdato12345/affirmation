<template>
  <div tabindex="0" class="relative flex justify-between px-3 py-3 border rounded-sm my-2">
    <div>
      <h2 v-if="!isEdit" class="font-medium max-w-[45ch]" @click.prevent="isEdit = true">
        {{ affirmation }}
      </h2>
      <FormInput v-else :id="id" autofocus label="Update affirmation" :model-value="affirmation" class="w-[400px]" @update:model-value="logUpdate" @keyup-enter="updateAffirmation" @blur="isEdit = false" />
      <p class="text-sm text-gray-500">
        {{ date }}
      </p>
    </div>
    <div class="absolute top-1/2 -translate-y-1/2 right-4 flex gap-x-1">
      <TrashIcon class="w-6 text-gray-500 hover:text-red-600 cursor-pointer" @click.prevent="emit('delete')" />
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
  console.log('Updating affirmation ...')
}

const logUpdate = (data) => {
  updatedText.value = data
}
</script>
