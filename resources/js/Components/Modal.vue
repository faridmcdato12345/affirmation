<template>
  <Teleport to="body">
    <div v-if="modelValue" class="fixed top-0 left-0 w-full h-screen">
      <div class="w-full h-full bg-gray-800/60" @click.prevent="emit('update:modelValue', !modelValue)"></div>
      <Transition name="slide-fade" appear>
        <div class="bg-white shadow-md p-6 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-sm md:w-[720px]">
          <slot></slot>
        </div>
      </Transition>
    </div>
  </Teleport>
</template>
<script setup>
defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue'])
</script>
<style scoped>
body {
  overflow: hidden;
}
</style>