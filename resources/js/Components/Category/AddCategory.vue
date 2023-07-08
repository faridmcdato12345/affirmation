<template>
  <div>
    <Modal v-model="modalShown">
      <div class="py-2">
        <h1 class="">
          Custom Category
        </h1>
        <p class="text-base mt-2 font-light">
          Add your own category so that you can add your own affirmation.
        </p>
        <form class="mt-3" @submit.prevent="saveCategory">
          <FormInput id="category" v-model="form.text" :max-length="35" class="mb-1" label="Category" :error="form.errors.text" autofocus />
          <FormInput id="blurb" v-model="form.blurb" :max-length="150" label="Description" :error="form.errors.blurb" />
          <div class="flex justify-end gap-x-2 mt-3">
            <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
            <Button label="Save Category" color="success" type="submit" :loading="loading" />
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>
<script setup>
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

import { toast } from '../../Composables/useToast'

import Modal from '../Modal.vue'
import FormInput from '../FormInput.vue'
import Button from '../Button.vue'

const props = defineProps({
  modelValue: Boolean
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

const form = useForm({
  text: '',
  blurb: ''
})

const loading = ref(false)

const saveCategory = () => {
  loading.value = true
  form.post(route('user-category.store'), {
    onSuccess: () => {
      form.reset()
      emit('update:modelValue', false)
    },
    onError: () => {
      toast.error(form.errors.error ?? 'Fields are required')
    },
    onFinish: () => {
      setTimeout(() => {
        loading.value = false
      }, 100)
    }
  })
}
</script>
