<template>
  <div
    class="tooltip" :class="className">
    <QuestionMarkCircleIcon class="w-full h-6 fill-theme-green cursor-pointer" @click="openToolTip(props.currentHowTo)" />
    <div
      class="tooltiptext md:w-32 h-auto" :class="[
        {'active' : isActive},
        alignment ? 'alignment' : 'affirmation'
      ]">
      <HowToScale 
        v-if="alignment" 
        class="content" 
        @close-tooltip="closeToolTip(props.currentHowTo)" />
      <AffirmationAction 
        v-else 
        class="content"
        @close-tooltip="closeToolTip(props.currentHowTo)" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/solid'
import HowToScale from './HowToScale.vue'
import AffirmationAction from './AffirmationAction.vue'

const alignment = ref(null)
const experience = ref(null)
const isActive = ref(null)

const props = defineProps({
  currentHowTo: {
    type: String,
    required: true
  }
})
const closeToolTip = (val) => {
  if(val === 'alignment'){
    alignment.value = false
  }
  if(val === 'experience'){
    experience.value = false
  }
  isActive.value = false
}
const openToolTip = (val) => {
  isActive.value = !isActive.value
  if(val === 'alignment'){
    alignment.value = !alignment.value
    experience.value = false
  }
  if(val === 'affirmation'){
    alignment.value = false
    experience.value = !experience.value
  }
}
const className = computed(()=> {
  let val = ''
  if(props.currentHowTo === 'alignment'){
    val = 'alignment'
  }
  if(props.currentHowTo === 'affirmation'){
    val = 'affirmation'
  }
  return val
})
</script>

<style scoped>
.tooltip {
  position: relative;
}
.tooltiptext {
  visibility: hidden;
  background-color: #096A2E;
  color: #fff;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  /* transition: 0.5s; */
}
.tooltiptext.active {
  visibility: visible;
  padding: 10px;
}

.tooltiptext .content {
  opacity:0;
}
.tooltiptext.active .content{
  opacity:1;
  transition-delay: 0.4s;
}
@media only screen and (min-width: 300px) {
  .tooltiptext.alignment{
    width: 330px;
    height: auto;
    top: 100%;
    z-index: 100;
    left: -500%;
  }
  .tooltiptext.affirmation{
    width: 330px;
    height: auto;
    top: 100%;
    z-index: 100;
    left: -320%;
  }
  .tooltip.affirmation{
    position: absolute;
    top: 17%;
    left: 25%;
  }
}
@media only screen and (min-width: 1024px) {
  .tooltiptext.alignment{
    width: 400px;
    height: auto;
  }
  .tooltiptext.affirmation{
    width: 400px;
    height: auto;
  }
  .tooltip.affirmation{
    position: relative;
    top: 0%;
    left: 0%;
  }
  .tooltiptext.active {
    top: 5%;
    left: 105%;
  }
}


</style>