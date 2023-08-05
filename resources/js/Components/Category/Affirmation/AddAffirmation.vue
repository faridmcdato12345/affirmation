<template>
  <div>
    <Modal v-model="modalShown">
      <div class="py-2">
        <h1 class="">
          Custom Affirmation
        </h1>
        <p class="text-base mt-2 font-light">
          Add your own custom affirmation for your selected category.
        </p>
        <form class="mt-3" @submit.prevent="saveAffirmation">
          <FormInput id="text" v-model="form.text" class="mb-1" label="Affirmation" />
          <div class="flex justify-end gap-x-2 mt-3">
            <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
            <Button label="Save Affirmation" color="success" type="submit" :loading="loading" />
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { computed, ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'

import Modal from '../../Modal.vue'
import FormInput from '../../FormInput.vue'
import Button from '../../Button.vue'
import { toast } from '../../../Composables/useToast'

const props = defineProps({
  modelValue: Boolean,
  category: {
    type: Object,
  },
  errors: Object
})

let form = reactive({
  text: '',
  user_categories_id: null
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

const saveAffirmation = () => {
  loading.value = true
  router.post(route('user-affirmation.store'), {
    ...form,
    user_categories_id: props.category.id,
  }, {
    onSuccess: () => {
      toast.success('Affirmation has been added successfully!')
      emit('update:modelValue')
    },
    onError: () => {
      toast.error(props.errors.error ?? 'You need to be premium to add more affirmations')
      loading.value = false
    },
    onFinish: () => {
      loading.value = false
    }
  })
}
</script>
