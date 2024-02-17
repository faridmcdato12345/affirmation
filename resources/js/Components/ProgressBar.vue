<template>
  <div>
    <div v-if="done" class="flex items-center justify-center">
      <Button size="xl" type="button" label="Relaunch Now" color="success" btn-block rounded />
    </div>
    <div v-else class="relative bg-gray-200 h-4 rounded-full w-full progress-container overflow-hidden">
      <div class="progress" :style="`width: ${progress}%`">
      </div>
      <p class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white flex items-center justify-center h-full animate-pulse">
        {{ progress.toFixed() }}% Updating...
      </p>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Button from './Button.vue'
const props = defineProps({
  duration: {
    type: Number,
    default: 60
  }
})

const progress = ref(0)
const done = ref(false)
let intervalId

const startProgressBar = () => {
  let currentProgress = 0
  intervalId = setInterval(() => {
    currentProgress += (100 / props.duration)
    progress.value = Math.min(currentProgress, 100)
    if(progress.value >= 100){
      clearInterval(intervalId)
      done.value = true
    }
  },1000)
}
onMounted(() => {
  startProgressBar()
})
onUnmounted(() => {
  clearInterval(intervalId)
})

</script>
<style scoped>
.progress-container{
  width: 100%;
  height: 20px;
  background-color: #e0e0e0;
  margin-bottom: 10px;
}
.progress {
  height: 100%;
  background-color: #4CAF50;
  transition: width 0.2s ease;
}
</style>