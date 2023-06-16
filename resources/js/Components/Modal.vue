<template>
  <Teleport to="body">
    <div v-if="modelValue" class="fixed top-0 left-0 w-full h-screen z-[21]">
      <div class="w-full h-full bg-gray-800/60" @click.prevent="closeModal"></div>
      <Transition name="slide-fade" appear>
        <div class="bg-white shadow-md border p-6 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-sm w-[96%] md:max-w-[640px]">
          <slot></slot>
        </div>
      </Transition>
    </div>
  </Teleport>
</template>
<script setup>
const props = defineProps({
  modelValue: Boolean,
  persistent: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])

const closeModal = () => {
  if(props.persistent) return 
  emit('update:modelValue', !props.modelValue)
}
</script>
<style scoped>
body {
  overflow: hidden;
}
</style>