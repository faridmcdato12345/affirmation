<template>
  <div class="mt-4">
    <p class="leading-4 text-gray-700 dark:text-gray-300">
      Share 0-3 examples in your life that fit this affirmation
    </p>
    <FormInput id="input1" v-model="experience.input1" label="First Example" required />
    <FormInput id="input2" v-model="experience.input2" label="Second Example" required />
    <FormInput id="input3" v-model="experience.input3" label="Third Example" required />
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