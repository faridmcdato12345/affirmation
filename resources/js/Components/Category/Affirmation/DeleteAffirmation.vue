<template>
  <div>
    <Modal v-model="modalShown">
      <div class="py-2">
        <h1 class="">
          Delete Affirmation
        </h1>
        <p class="text-base mt-2 font-light">
          Are you sure you want to delete this affirmation?
        </p>
        <div class="flex justify-end gap-x-2 mt-3">
          <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
          <Button label="Delete" color="error" :loading="loading" @click.prevent="deleteAffirmation" />
        </div>
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { toast } from '../../Composables/useToast'

import Modal from '../Modal.vue'
import Button from '../Button.vue'

const props = defineProps({
  modelValue: Boolean,
  affirmationId: [Number, String],
  category: {
    type: String,
    default: ''
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

const loading = ref(false)

const deleteAffirmation = () => {
  loading.value = true
  router.delete(route('user-affirmation.destroy', props.affirmationId), {
    onSuccess: () => {
      toast.success('Affirmation has been deleted successfully!')
      emit('update:modelValue', false)
    },
    onFinish: () => {
      setTimeout(() => {
        loading.value = false
      }, 100)
    }
  })
}
</script>
