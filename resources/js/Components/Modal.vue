<template>
  <Teleport to="body">
    <div 
      v-if="modelValue" 
      class="fixed top-0 left-0 w-full h-screen z-[100]" 
      :class="{ 'modal-open' : modelValue }">
      <div class="w-full h-full dark:bg-gray-900/70 bg-gray-800/70" @click.prevent="closeModal"></div>
      <Transition name="slide-fade" appear>
        <div
          class="bg-white dark:bg-gray-800  dark:border-gray-700 shadow-md border p-6 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-sm"
          :class="!checkRoute ? `w-[96%] ${modalWidth}` : 'w-[96%] md:w-auto'">
          <slot></slot>
        </div>
      </Transition>
    </div>
  </Teleport>
</template>
<script setup>
import { watch, ref, computed, onMounted } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  persistent: {
    type: Boolean,
    default: false
  },
  maxWidth: {
    type: String,
    default: 'lg'
  }
})

const checkRoute = ref(true)

const emit = defineEmits(['update:modelValue'])

const modalWidth = computed(() => {
  return {
    'sm': 'md:max-w-[400px]',
    'default': 'md:max-w-[500px]',
    'lg': 'md:max-w-[640px]'
  }[props.maxWidth]
})

watch(() => props.modelValue, (val) => {
  if(val) {
    document.body.classList.add('overflow-hidden')
  } else {
    document.body.classList.remove('overflow-hidden')
  }
})

const closeModal = () => {
  if(props.persistent) return
  emit('update:modelValue', !props.modelValue)
}

const route = window.location.pathname

if(route.includes('calendar')){
  checkRoute.value = false
}

onMounted(() => {
  document.addEventListener('keyup', (evt) => {
    if (evt.keyCode === 27) {
      emit('update:modelValue', false)
    }
  })
})

</script>
