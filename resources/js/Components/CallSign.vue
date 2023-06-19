<script setup>
defineProps({
  value: {
    type: String,
  },
})
</script>

<template>
  <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl flex justify-center items-center mb-10">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot /></span>
  </h1>
</template>