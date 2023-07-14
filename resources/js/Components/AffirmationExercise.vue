<template>
  <div>
    <div class="absolute right-8">
      <p class="text-rose-500 font-medium">
        Step {{ step }} / 3
      </p>
    </div>
    <div>
      <h3 class="font-medium text-2xl">
        {{ currentTitle }}
      </h3>
      <p class="leading-5">
        {{ currentDescription }}
      </p>
    </div>
    <Transition appear>
      <div>
        <AffirmationRate v-if="step == 1" v-model="formData" />
        <AffirmationExperience v-if="step == 2" v-model="formData" />
        <AffirmationFinish v-if="step == 3" />
        <Button :label="step < 3 ? 'Next' : 'STAY AWESOME!'" btn-block class="mt-4" :loading="formData.processing" @click.prevent="nextStep" />
      </div>
    </Transition>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { useAffirmationExercise } from '../Composables/useAffirmationExercise'
import { toast } from '../Composables/useToast'

import Button from './Button.vue'
import AffirmationRate from './Affirmation/AffirmationRate.vue'
import AffirmationExperience from './Affirmation/AffirmationExperience.vue'
import AffirmationFinish from './Affirmation/AffirmationFinish.vue'

const props = defineProps({
  progressId: {
    type: [Number, String],
    required: true
  }
})

const step = ref(1)
const { stepsTitle, stepsDescription } = useAffirmationExercise()

const formData = useForm({
  progress_id: props.progressId,
  happiness_score: 0,
  belief_score: 0,
  input1: '',
  input2: '',
  input3: '',
})

const nextStep = () => {
  if(step.value == 3) {
    formData.post(route('exercise.store'), { // eslint-disable-line no-undef
      onSuccess: () => {
        toast.success('Today\'s exercise has been completed successfuly!')
        formData.reset()
        emit('close-modal')
      }   
    })  
  }

  if(step.value < 3) step.value++ 
} 

const emit = defineEmits(['close-modal'])
const currentTitle = computed(() => stepsTitle[step.value] ?? '')
const currentDescription = computed(() => stepsDescription[step.value] ?? '')
</script>
<style>
.Rate .icon {
  width: 30px;
  height: 30px ;
}

.icon:hover {
  color: #efc20f
}
</style>