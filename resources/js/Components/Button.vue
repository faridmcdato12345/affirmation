<template>
  <component
    :is="componentType == 'link' ? Link : 'button'"
    :href="href"
    :type="type"
    :class="[
      'duration-150 ease-out text-white text-center',
      btnSize, btnColor,
      {
        'w-full block': btnBlock
      },
      rounded ? 'rounded-full' : 'rounded-lg'
    ]">
    {{ text }}
  </component>
</template>
<script setup>
import { computed } from 'vue'
// eslint-disable-next-line no-unused-vars
import { Link } from '@inertiajs/vue3'

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
  },
  rounded: {
    type: Boolean,
    default: false
  },
  componentType: {
    type: String,
    default: 'button'
  },
  href: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'button'
  }
})

const btnSizeClass = {
  'sm': 'px-4 py-2 text-xs',
  'base': 'px-4 py-2.5 text-sm',
  'lg': 'px-14 py-3 text-lg',
  'xl': 'px-14 py-3 text-xl'
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
  if(props.outline) return `border-2 border-${btnColorClass[props.color]}-600 border-solid`
  return `bg-${btnColorClass[props.color]}-600 hover:bg-${btnColorClass[props.color]}-700 active:bg-${btnColorClass[props.color]}-800 focus:ring focus:ring-${btnColorClass[props.color]}-600`
})
</script>