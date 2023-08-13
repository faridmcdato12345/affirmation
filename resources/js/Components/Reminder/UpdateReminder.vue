<template>
  <Modal v-model="modalShown">
    <div class="text-left">
      <h1 class="mt-2 mb-8">
        Edit Personal Reminder
      </h1>
    </div>
    <hr />
    <form class="mt-8" @submit.prevent="updateTime">
      <div class="edit-modal-body">
        <FormInput id="input1" v-model="form.original_time" label="Time" required type="time" :error="form.errors.original_time" />
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
import { computed, watch  } from 'vue'
import FormInput from '../FormInput.vue'
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
</script>