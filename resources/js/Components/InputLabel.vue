<script setup>
defineProps({
  value: {
    type: String,
  },
})
</script>

<template>
  <label class="block font-medium text-sm text-gray-950 dark:text-gray-950 mb-2">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot></slot></span>
  </label>
</template>