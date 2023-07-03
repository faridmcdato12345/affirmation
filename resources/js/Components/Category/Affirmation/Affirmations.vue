<template>
  <div>
    <Modal v-model="modalShown">
      <div class="py-2">
        <h1 class="">
          Affirmations
        </h1>
        <p class="text-base mt-2 font-light">
          Here are your custom affirmations for the selected category
        </p>
        <div class="max-h-[300px] overflow-y-auto">
          <div class="relative flex justify-between px-3 py-3 border rounded-sm my-2">
            <div>
              <h2 class="font-medium">
                Affirmation Title
              </h2>
              <p class="text-base text-gray-500">
                Affirmation Description
              </p>
            </div>
            <div class="absolute top-3 right-3 flex gap-x-1">
              <PencilSquareIcon class="w-5 text-gray-500 hover:text-green-600 cursor-pointer" />
              <TrashIcon class="w-5 text-gray-500 hover:text-red-600 cursor-pointer" />
            </div>
          </div>
        </div>
        <div class="flex justify-end mt-4 gap-x-2">
          <Button label="Close" color="gray" @click.prevent="emit('update:modelValue', false)" />
          <Button label="Add Affirmation" color="success" @click.prevent="emit('update:modelValue', false)" />
        </div>
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { computed  } from 'vue'
//   import { router } from '@inertiajs/vue3'
//   import { toast } from '../../Composables/useToast'

import Modal from '../../Modal.vue'
import Button from '../../Button.vue'
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  modelValue: Boolean,
  affirmations: {
    type: Object,
    default: () => {}
  }
})

const emit = defineEmits(['update:modelValue'])

const modalShown = computed({
  get() {
    return props.modelValue
  },
  set(val) {
    emit('update:modelValue', val)
  }
})

// const loading = ref(false)
</script>
