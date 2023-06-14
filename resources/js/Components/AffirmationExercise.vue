<template>
  <div>
    <div class="flex justify-between">
      <div>
        <h3 class="font-medium text-2xl">
          Alignment
        </h3>
        <p>Who are you inside is what helps you make and do everything in life.</p>
      </div>
      <p>
        Step {{ step }} / 3
      </p>
    </div>
    <AffirmationRate :form-data="formData" />
    <Button label="Next" btn-block class="mt-4" @click.prevent="nextStep" />
  </div>
</template>
<script setup>
import { reactive, ref } from 'vue'
import Button from './Button.vue'
import AffirmationRate from './Affirmation/AffirmationRate.vue'

const formData = reactive({
  happinessScore: 0,
  beliefScore: 0,
  input1: '',
  input2: '',
  input3: '',
})

const step = ref(1)

const nextStep = () => {
  if(step.value < 3) step.value++
}
</script>
<style>
.Rate .icon {
  width: 30px;
  height: 30px ;
}
</style>