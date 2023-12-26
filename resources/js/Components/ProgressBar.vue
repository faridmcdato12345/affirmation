<template>
  <div class="bg-gray-200 h-4 rounded-full w-full">
    <div class="progress" :style="`width: ${progress}%;`"></div>
  </div>
</template>
<script>
export default {
}
</script>
<style scoped>
@keyframes progress {
  0%{
    @apply bg-theme-green
  }
  10%{
    @apply bg-theme-green
  }
  20%{
    @apply bg-theme-green
  }
  30%{
    @apply bg-theme-green
  }
  40%{
    @apply bg-theme-green
  }
  50%{
    @apply bg-theme-green
  }
  60%{
    @apply bg-theme-green
  }
  70%{
    @apply bg-theme-green
  }
  80%{
    @apply bg-theme-green
  }
  90%{
    @apply bg-theme-green
  }
  100%{
    @apply bg-theme-green
  }
}
.progress{
  @apply h-full rounded-full transition-all ease-in-out duration-150;
  animation: progress 2s infinite linear;
}
</style>