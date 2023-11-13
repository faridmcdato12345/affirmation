<template>
  <div>
    <h1 class="font-medium text-2xl text-white">
      What to do?
    </h1>
    <HowToScaleFirst v-if="step == 1" />
    <HowToScaleSecond v-if="step == 2" />
    <Button 
      :label="step < 2 ? 'Next' : 'GOT IT!'" 
      btn-block 
      :darken="step >= 2"
      class="mt-4" 
      color="success"
      @click.prevent="nextStep" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Button from './Button.vue'
import HowToScaleFirst from './HowToScaleFirst.vue'
import HowToScaleSecond from './HowToScaleSecond.vue'


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
.nested-list{
    padding-left: 5%;
}
</style>