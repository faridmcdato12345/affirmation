<template>
  <Modal v-model="modalShown">
    <div class="text-left">
      <h1 class="mt-2 dark:text-white">
        Add Reminder
      </h1>
      <p class="mb-4">
        Select the time that you want to get notified and write your own message.
      </p>
    </div>
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
          placeholder="Write your custom message here"
          class="border-2 border-green-700 w-full rounded-md px-2 py-1 dark:bg-gray-800 mt-4"></textarea>
      </div>
      <div class="flex justify-end gap-x-2 mt-4">
        <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
        <Button label="Save Reminder" type="submit" color="success" />
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