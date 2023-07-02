<template>
  <component
    :is="componentType == 'link' ? Link : 'button'"
    :href="href"
    :type="type"
    :disabled="loading"
    :class="[
      'duration-150 ease-out text-white text-center flex',
      btnSize, btnColor,
      {
        'w-full block': btnBlock
      },
      rounded ? 'rounded-full' : 'rounded-lg'
    ]">
    <span class="flex mx-auto">
      <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
      </svg>
      {{ text }}
    </span>
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
  },
  loading: {
    type: Boolean,
    default: false
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
  return `bg-${btnColorClass[props.color]}-600 hover:bg-${btnColorClass[props.color]}-700 active:bg-${btnColorClass[props.color]}-800 disabled:hover:bg-${btnColorClass[props.color]}-600 focus:ring focus:ring-${btnColorClass[props.color]}-600`
})
</script>
