<template>
  <input
    v-bind="$attrs"
    :placeholder="label"
    :value="modelValue"
    class="border-2 border-theme-green text-gray-900 sm:text-sm rounded-lg focus:ring-theme-green focus:border-theme-green block w-full p-2.5 dark:border-theme-green  dark:focus:ring-theme-green dark:focus:border-theme-green"
    required="" 
    @input="$emit('update:modelValue', $event.target.value)" />
</template>
<script setup>
defineProps({
  label: {
    type:String,
    default: ''
  },
  modelValue: {
    type: [String, Number],
    default: ''
  }
})
</script>