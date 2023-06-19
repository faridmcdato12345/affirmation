<template>
  <font-awesome-icon v-if="modelValue" icon="fa-solid fa-eye" style="transform: translateY(-50%);" class="hover:text-hover-theme-green absolute top-1/2 right-4 cursor-pointer text-theme-green" @click.prevent="emit('update:modelValue',!modelValue)" />
  <font-awesome-icon v-else icon="fa-solid fa-eye-slash" style="transform: translateY(-50%);" class="hover:text-hover-theme-green absolute top-1/2 right-4 cursor-pointer text-theme-green" @click.prevent="emit('update:modelValue',!modelValue)" />
</template>
<script setup>
defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue'])
</script>