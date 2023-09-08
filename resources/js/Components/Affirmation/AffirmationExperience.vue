<template>
  <div class="mt-4">
    <p class="leading-4 text-gray-700 dark:text-gray-300">
      Enter 0-3 times your actions or beliefs have been in line with this affirmation.
    </p>
    <FormInput id="input1" v-model="experience.input1" label="First Experience" required />
    <FormInput id="input2" v-model="experience.input2" label="Second Experience" required />
    <FormInput id="input3" v-model="experience.input3" label="Third Experience" required />
  </div>
</template>
<script setup>
import { computed } from 'vue'
import FormInput from '../FormInput.vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const experience = computed({
  get() {
    return props.modelValue
  },
  set(val) {
    emit('update:modelValue', val)
  }
})

</script>
<style>
.Rate .icon {
  width: 30px;
  height: 30px ;
}
</style>