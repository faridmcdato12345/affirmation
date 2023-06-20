<template>
  <div>
    <div
      class="h-screen w-full fixed -z-[1]" style="background-image: linear-gradient(
      to bottom,
      rgba(000, 000, 000, 0.5),
      rgba(000, 000, 000, 0.5)
      ), url('/images/bg1.jpg');
      background-repeat: no-repeat;
      background-size: cover;
    "></div>
    <NavigationBar />
    <div class="w-full h-screen">
      <slot></slot>
    </div>
  </div>
</template>
<script setup>
import NavigationBar from '../Components/NavigationBar.vue'
defineProps({
  backgroundImage: {
    type: String,
    required: true
  }
})
</script>