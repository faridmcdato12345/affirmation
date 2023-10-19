<template>
  <div>
    <BarChart :chart-data="data" class="h-full flex w-full justify-center items-center" />
    <div v-if="!user_type.paid">
      <div class="text-center mt-2">
        <component 
          :is="ChevronDoubleDownIcon" 
          class="w-4 mx-auto text-theme-green duration-200 ease-out animate-bounce" />
        <span class="text-xs md:text-sm text-theme-green">Subscribe to premium account to show all your progress</span>
      </div>
    </div>
  </div>
</template>
<script setup>
import { Chart, registerables } from 'chart.js'
import { BarChart } from 'vue-chart-3'
import { reactive } from 'vue'
import { ChevronDoubleDownIcon } from '@heroicons/vue/24/solid'

Chart.register(...registerables)
const response = defineProps({
  result: Object
})
const user_type = reactive({
  paid: false
})
if(response.result.user_is_paid){
  user_type.paid = true
}
const data = reactive({
  labels: response.result.data.label,
  options:{
    reponsive: true
  },
  datasets: [
    {
      label: 'Happiness',
      data: response.result.data.happiness,
      borderColor:'#096A2E',
      backgroundColor:'#096A2E',
    },
    {
      label: 'Belief',
      data: response.result.data.belief,
      borderColor:'#8ABE53',
      backgroundColor: '#8ABE53',
    },
  ],
})



</script>