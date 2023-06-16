<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg">
    <!-- <p>{{ categories }}</p> -->
    <!-- <p>{{ activeCategory }}</p> -->
    <div class="h-screen w-full bg-gray-900/60 absolute"></div>
    <div class="h-screen flex flex-col justify-center md:max-w-7xl mx-auto z-20 relative">
      <h1 class="text-white">
        Categories
      </h1>
    </div>
  </AuthenticatedLayout> 
</template>
<script setup>
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'

defineProps({
  categories: Object,
  activeCategory: [Object, Number]
})
</script>