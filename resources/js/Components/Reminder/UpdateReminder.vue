<template>
  <div>
    <Modal v-model="modalShown">
      <div class="text-left">
        <h1 v-if="isMobile" class="mt-2 mb-8 dark:text-white">
          Update Personal Reminder
        </h1>
        <h1 v-else class="mt-2 mb-8 dark:text-white">
          Edit Personal Reminder
        </h1>
      </div>
      <hr />
      <form class="mt-8" @submit.prevent="updateTime">
        <div class="edit-modal-body">
          <FormInput id="input1" v-model="form.original_time" label="Time" required type="time" :error="form.errors.original_time" />
          <textarea
            id="custom_message"
            v-model="form.custom_message"
            name=""
            cols="10"
            rows="4"
            placeholder="Write your custom message here"
            class="border-2 border-hover-theme-green w-full rounded-md px-2 py-1 dark:bg-gray-800 mt-4">
          </textarea>
        </div>
        <div class="flex justify-end gap-x-1 mt-4">
          <Button 
            label="Cancel" 
            color="gray" 
            @click.prevent="modalShown = false" />
          <Button 
            v-if="isMobile" 
            label="Delete" 
            type="button" 
            color="error" 
            @click.prevent="deleteReminder" />
          <Button 
            label="Save Reminder" 
            type="submit" 
            color="success" />
        </div>
      </form>
    </Modal>
    <DeleteReminderModal v-if="isMobile" v-model="deleteTimeModal" :reminder="props.reminder" />
  </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import Button from '../Button.vue'
import Modal from '../Modal.vue'
import { computed, watch  } from 'vue'
import FormInput from '../FormInput.vue'
import { isMobile } from 'mobile-device-detect'
import { toast } from '../../Composables/useToast'
import DeleteReminderModal from './DeleteReminder.vue'
import { ref } from 'vue'
  
const props = defineProps({
  modelValue: Boolean,
  reminder: Object
})
const deleteTimeModal = ref(false)
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
  original_time: '',
  custom_message: ''
})
watch(() => props.reminder, () => {
  form = useForm({...props.reminder})
  console.log('Forms: ', form)
})
const updateTime = () => {
  form.patch(route('setting.reminder.update',form.id),{
    onSuccess: () => {
      form.reset()
      toast.success('Time has been updated successfully!')
      emit('update:modelValue', false)
    },
    onError: () => {
      if(form.errors) {
        toast.error('All fields are required')
      }
    }
  })
}
const deleteReminder = () => {
  emit('update:modelValue', false)
  deleteTimeModal.value = true
}
</script>