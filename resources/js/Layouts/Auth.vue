<template>
  <div class="h-screen w-full flex">
    <div class="hidden md:block w-full h-screen relative">
      <img src="/images/bg1.jpg" alt="Background Image" class="object-cover h-full w-full brightness-50" />
      <div class="typewriter w-4/5 absolute bottom-16 left-16">
        <h1 class="text-white font-normal text-2xl md:text-3xl">
          Affirmation is like a gentle breeze that whispers hope to the soul, strengthening our belief in ourselves and reminding us of the power we hold within.
        </h1>
      </div>
    </div>
    <div class="flex md:w-[768px] h-screen w-full items-center justify-center">
      <div class="p-6 sm:p-8 w-full max-w-lg">
        <div class="flex justify-center items-center">
          <img src="/images/icons/256.png" width="150" height="150" alt="affirm" srcset="" />
        </div>
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script setup>
</script>
<style scoped>
</style>