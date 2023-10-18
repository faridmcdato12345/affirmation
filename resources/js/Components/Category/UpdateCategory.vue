<template>
  <div>
    <Modal v-model="modalShown">
      <div class="py-2">
        <h1 class="dark:text-white">
          Update Category
        </h1>
        <p class="dark:text-gray-300 text-base mt-2 font-light">
          Update the text and description of your category
        </p>
        <form class="mt-5" @submit.prevent="updateCategory">
          <FormInput id="category" v-model="form.text" :max-length="35" class="mb-1" label="Category" :error="form.errors.text" />
          <FormInput id="blurb" v-model="form.blurb" :max-length="150" label="Description" :error="form.errors.blurb" />
          <div class="flex justify-end gap-x-2 mt-3">
            <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
            <Button label="Update Category" color="success" type="submit" :loading="loading" />
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { computed, ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

import { toast } from '../../Composables/useToast'

import Modal from '../Modal.vue'
import FormInput from '../FormInput.vue'
import Button from '../Button.vue'

const props = defineProps({
  modelValue: Boolean,
  category: Object
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

let form = useForm({
  text: '',
  blurb: ''
})

watch(() => props.category, () => {
  form = useForm({...props.category})
})

const loading = ref(false)

const updateCategory = () => {
  loading.value = true
  form.put(route('user-category.update', form.id), {
    onSuccess: () => {
      form.reset()
      toast.success('Category has been updated successfully!')
      emit('update:modelValue', false)
    },
    onError: () => {
      if(form.errors) {
        toast.error('All fields are required')
      }
    },
    onFinish: () => {
      setTimeout(() => {
        loading.value = false
      }, 100)
    }
  })
}
</script>
