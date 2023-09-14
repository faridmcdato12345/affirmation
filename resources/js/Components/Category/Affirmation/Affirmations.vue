<template>
  <div>
    <Modal v-model="modalShown">
      <div class="py-2">
        <h1 class="dark:text-white">
          Affirmations
        </h1>
        <p class="dark:text-gray-300 text-base mt-2 font-light">
          Here are your custom affirmations for the selected category.
        </p>
        <div class="max-h-[300px] overflow-y-auto mt-2 py-1">
          <AffirmationCard 
            v-for="affirm in affirmations" 
            :id="affirm.id" 
            :key="affirm.id" 
            :affirmation="affirm.text" 
            :date="affirm.created_at" 
            @delete="destroy(affirm.id)" 
            @update="update" />
          <p v-if="affirmations.length == 0" class="dark:text-gray-300 text-base mt-2 mb-3">
            There are no affirmations added to this category.
          </p>
        </div>
        <p v-if="affirmations.length != 0" class="dark:text-gray-300 text-sm">
          Click on an affirmation text to edit and press <span class="font-medium text-black dark:text-green-600">enter</span> to save update.
        </p>
        <div class="flex justify-end mt-4 gap-x-2">
          <Button label="Close" color="gray" @click.prevent="emit('update:modelValue')" />
          <Button label="Add Affirmation" color="success" @click.prevent="emit('add-affirmation')" />
        </div>
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { toast } from '../../../Composables/useToast'

import Modal from '../../Modal.vue'
import Button from '../../Button.vue'
import AffirmationCard from './AffirmationCard.vue'

const props = defineProps({
  modelValue: Boolean,
  affirmations: {
    type: Object,
    default: () => {}
  }
})

const emit = defineEmits(['update:modelValue', 'add-affirmation'])

const modalShown = computed({
  get() {
    return props.modelValue
  },
  set(val) {
    emit('update:modelValue', val)
  }
})

const loading = ref(false)

const update = (affirmation) => {
  console.log('Update affirmation: ', affirmation)
}

const destroy = (affirmation) => {
  loading.value = true
  router.delete(route('user-affirmation.destroy', affirmation), {
    onSuccess: () => {
      toast.success('Affirmation has been deleted successfully!')
    },
    onError: () => {
      loading.value = false
    },
    onFinish: () => {
      loading.value = false
    }
  })
}

// const loading = ref(false)
</script>
