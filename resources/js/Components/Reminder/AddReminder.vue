<template>
  <Modal v-model="modalShown">
    <div class="text-left">
      <h1 class="mt-2 mb-8">
        Add Personal Reminder
      </h1>
    </div>
    <hr />
    <form class="mt-8" @submit.prevent="addTime">
      <div class="edit-modal-body">
        <FormInput id="input1" v-model="form.original_time" label="Time" required type="time" :error="form.errors.original_time" />
        <textarea
          v-if="props.isSubscribed"
          id="custom_message"
          v-model="form.custom_message"
          name=""
          cols="10"
          rows="4"
          placeholder="Write your customer message here"
          class="border-2 border-hover-theme-green w-full rounded-md px-2 py-1 dark:bg-gray-800 mt-4"></textarea>
      </div>
      <div class="flex justify-end gap-x-2 mt-4">
        <Button label="Save" type="submit" color="success" />
        <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
      </div>
    </form>
  </Modal>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import Button from '../Button.vue'
import Modal from '../Modal.vue'
import { computed } from 'vue'
import FormInput from '../FormInput.vue'
import { toast } from '../../Composables/useToast'

const props = defineProps({
  modelValue: Boolean,
  isSubscribed: Boolean
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
  original_time: '',
  custom_message: ''
})
const addTime = () => {
  form.post(route('setting.reminder.store'),{
    onSuccess: () => {
      form.reset()
      toast.success('Time has been added successfully!')
      emit('update:modelValue', false)
    },
    onError: () => {
      toast.error(form.errors.error ?? 'Fields are required')
    }
  })
}
</script>