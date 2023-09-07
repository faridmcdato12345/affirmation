<template>
  <AuthenticatedLayout>
    <div class="h-screen flex flex-col items-center justify-center md:max-w-7xl">
      <h1 class="px-4 text-4xl md:px-0 md:text-6xl font-medium tracking-tight text-center text-white max-w-5xl">
        {{ modifiedAffirmation }}
      </h1>
      <Button
        :label="exerciseFinished ? 'Today\'s Exercise Complete' : 'Begin Exercise'"
        size="lg"
        rounded
        color="success"
        class="mt-4"
        @click.prevent="checkDailyExerciseStatus" />
    </div>
    <Modal v-model="modalShown">
      <AffirmationExercise 
        :progress-id="progressId" 
        :affirmation="modifiedAffirmation" 
        @close-modal="modalShown = false" />
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Button from '../Components/Button.vue'
import Modal from '../Components/Modal.vue'
import AffirmationExercise from '../Components/AffirmationExercise.vue'
import { toast } from '../Composables/useToast'
import { usePage } from '@inertiajs/vue3'
import { useInsertIndexdb } from '../Composables/useInsertIndexdb'

const props = defineProps({
  affirmation: Object,
  progressId: [Number, String],
  exerciseFinished: Boolean,
  isSubscribed: Boolean,
  isNotify: [Boolean, Number],
  user_id: Number
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const modalShown = ref(false)

const { insertData } = useInsertIndexdb()

localStorage.setItem('isSubcribe', props.isSubscribed)
localStorage.setItem('isNotify', props.isNotify)
localStorage.setItem('userId', props.user_id)

const checkDailyExerciseStatus = () => {
  if(props.exerciseFinished) {
    return toast('You\'ve already completed today\'s exercise')
  } 

  modalShown.value = true
}

onMounted(() => {
  insertData(props.user_id)
})

const modifiedAffirmation = computed(() => props.affirmation?.text.replace(/\{([^}]+)\}/, user.value.name))
</script>
