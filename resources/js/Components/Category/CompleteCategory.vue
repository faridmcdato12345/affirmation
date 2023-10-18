<template>
  <div class="w-full h-full items-center justify-center">
    <HandThumbUpIcon class="w-20 h-20 text-rose-500 mx-auto" />
    <h3 class="font-medium text-2xl text-center mt-2 dark:text-white">
      Congratulation! 
    </h3>
    <p class="text-center dark:text-gray-300">
      You have completed all the affirmations under the selected category.
    </p> 
  </div>
</template>
<script setup>
import { HandThumbUpIcon } from '@heroicons/vue/24/solid'
</script>