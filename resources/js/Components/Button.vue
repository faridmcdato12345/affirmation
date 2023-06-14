<template>
  <button
    :class="[
      'duration-150 ease-out rounded-lg text-white',
      btnSize, btnColor,
      {
        'w-full block': btnBlock
      }
    ]">
    {{ text }}
  </button>
</template>
<script setup>
import { computed } from 'vue'
const props = defineProps({
  label: {
    type: String,
    required: true
  },
  uppercase: {
    type: Boolean,
    default: false
  },
  btnBlock: {
    type: Boolean,
    default: false
  },
  color: {
    type: String,
    default: 'primary'
  },
  outline: {
    type: Boolean,
    default: false
  },
  size: {
    type: String,
    default: 'base'
  }
})

const btnSizeClass = {
  'sm': 'px-4 py-2 text-xs',
  'base': 'px-4 py-2.5 text-sm',
  'lg': 'px-14 py-3 text-lg',
  'xl': 'px-7 py-3 text-xl'
}

const btnColorClass = {
  'success': 'green',
  'error': 'red',
  'warning': 'orange',
  'primary': 'blue',
}

const text = computed(() => props.uppercase ? props.label.toUpperCase() : props.label)
const btnSize = computed(() => btnSizeClass[props.size])
const btnColor = computed(() => {
  if(props.outline) return `border-2 border-${btnColorClass[props.color]}-500 border-solid`
  return `bg-${btnColorClass[props.color]}-500 hover:bg-${btnColorClass[props.color]}-600 active:bg-${btnColorClass[props.color]}-700 focus:ring focus:ring-${btnColorClass[props.color]}-600`
})
</script>