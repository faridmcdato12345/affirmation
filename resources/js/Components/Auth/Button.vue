<template>
  <div class="w-full">
    <button type="submit" class="w-full sm:w-full  bg-theme-green hover:bg-hover-theme-green focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center text-white dark:bg-theme-green dark:hover:bg-primary-700 dark:focus:ring-primary-800">
      {{ label }}
    </button>  
  </div>
</template>
<script setup>
defineProps({
  label: {
    type: String,
    default: ''
  }
})
</script>