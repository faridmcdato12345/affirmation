<template>
  <div class="relative mt-2">
    <input
      :id="id"
      ref="inputRef"
      :value="modelValue"
      :type="type"
      class="block px-2.5 py-3 w-full text-base text-gray-900 dark:text-gray-200 bg-transparent rounded-lg border-2 border-hover-theme-green appearance-none focus:outline-none focus:ring-0 focus:border focus:border-green-600 peer"
      placeholder=" "
      autofocus
      :required="required"
      :maxlength="maxLength"
      @input="(e) => emit('update:modelValue', e.target.value)"
      @blur="emit('blur')"
      @keyup.enter="emit('keyup-enter')" />
    <label :for="id" class="dark:border-gray-800 dark:bg-gray-800 absolute text-sm cursor-text dark:text-gray-300 text-gray-500 duration-300 transform -translate-y-4 scale-75 top-1.5 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-green-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-8 peer-focus:top-1.5 peer-focus:scale-75 left-1">
      {{ label }}
    </label>
    <div class="absolute right-4 top-[18px]">
      <slot name="icon-right"></slot>
    </div>
    <div class="flex justify-between">
      <p class="text-xs text-red-500 ml-2">
        {{ error }}
      </p>
      <p v-if="maxLength" :class="{'text-red-500' : modelValue.length >= maxLength}">
        {{ modelValue.length }} / {{ maxLength }}
      </p>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
const props = defineProps({
  label: {
    type: String,
    required: true
  },
  id: {
    type: [String, Number],
    required: true
  },
  type: {
    type: String,
    default: 'text'
  },
  modelValue: {
    type: String,
    required: true
  },
  error: {
    type: String,
    default: ''
  },
  required: {
    type: Boolean,
    default: false
  },
  maxLength: {
    type: [String, Number],
    default: null
  },
  autofocus: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'blur', 'keyup-enter'])

const inputRef = ref('')

onMounted(() => {
  if(props.autofocus) {
    inputRef.value.focus()
  }
})
</script>
