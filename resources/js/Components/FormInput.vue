<template>
  <div class="relative mt-2">
    <input
      :id="id"
      :value="modelValue" 
      :type="type" 
      class="block px-2.5 py-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
      placeholder=" " 
      :required="required"
      @input="(e) => emit('update:modelValue', e.target.value)" />
    <label :for="id" class="absolute text-sm cursor-text text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:top-8 peer-focus:top-2 peer-focus:scale-75 left-1">
      {{ label }}    
    </label>
    <p v-if="error" class="text-xs text-red-500 ml-2">
      {{ error }}
    </p>
  </div>
</template>
<script setup>
defineProps({
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
  }
})

const emit = defineEmits(['update:modelValue'])
</script>