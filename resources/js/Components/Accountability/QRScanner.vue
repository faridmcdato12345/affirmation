<template>
  <Modal v-model="modalShown">
    <div class="mb-3">
      <h3 class="mb-0">
        Scan QR
      </h3>
      <p class="mb-4">
        Scan the QR Code of your Friend
      </p>
      <div class="mt-5 min-w-[320px]">
        <qrcode-stream @detect="onDetect" @error="onError" />
      </div>
    </div>
  </Modal>
</template>
<script setup>
import { computed } from 'vue'
import Modal from '../Modal.vue'

const props = defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'send-invite'])

const modalShown = computed({
  get() {
    return props.modelValue
  },
  set(val) {
    emit('update:modelValue', val)
  }
})

const onDetect = (detectedValue) => {
  emit('send-invite', detectedValue?.[0].rawValue)
  emit('update:modelValue', false)
}

const onError = (errorValue) => {
  console.log('Error Value: ', errorValue)
}
</script>