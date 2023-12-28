<template>
  <div>
    <div>
      <h1 class="font-medium text-2xl text-white">
        Instructions:
      </h1>
      <HowToReflectFirst v-if="step == 1" />
      <HowToReflectSecond v-if="step == 2" />
      <Button 
        :label="step < 2 ? 'Next' : 'GOT IT!'" 
        btn-block 
        :darken="step >= 2"
        class="mt-4" 
        color="success"
        @click.prevent="nextStep" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Button from './Button.vue'
import HowToReflectFirst from './HowToReflectFirst.vue'
import HowToReflectSecond from './HowToReflectSecond.vue'

const step = ref(1)

const nextStep = () => {
  if(step.value == 2) {
    emit('close-tooltip')
  }

  if(step.value < 2) step.value++ 
} 
const emit = defineEmits('close-tooltip')
</script>

<style scoped>
p{
  color: #fff;
}
</style>