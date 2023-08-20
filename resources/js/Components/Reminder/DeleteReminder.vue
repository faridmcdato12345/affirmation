<template>
  <Modal v-model="modalShown">
    <div class="py-2">
      <h1 class="">
        Delete Reminder
      </h1>
      <p class="text-base mt-2 font-light">
        Are you sure you want to delete this reminder?
      </p>
      <div class="flex justify-end gap-x-2 mt-3">
        <Button label="Cancel" color="gray" @click.prevent="modalShown = false" />
        <Button label="Delete" color="error" :loading="loading" @click.prevent="deleteReminder" />
      </div>
    </div>
  </Modal>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import Button from '../Button.vue'
import Modal from '../Modal.vue'
import { computed, watch  } from 'vue'
import { toast } from '../../Composables/useToast'
  
const props = defineProps({
  modelValue: Boolean,
  reminder: Object
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
  original_time: ''
})
watch(() => props.reminder, () => {
  form = useForm({...props.reminder})
})
const deleteReminder = () => {
  form.delete(route('setting.reminder.delete',form.id),{
    onSuccess: () => {
      form.reset()
      toast.success('Time has been deleted successfully!')
      emit('update:modelValue', false)
    },
    onError: () => {
      if(form.errors) {
        toast.error('All fields are required')
      }
    }
  })
}
</script>