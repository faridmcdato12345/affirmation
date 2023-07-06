<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg">
    <div class="h-screen flex flex-col items-center justify-center md:max-w-7xl mx-auto">
      <h1 class="px-4 text-4xl md:px-0 md:text-6xl font-medium tracking-tight text-center text-white max-w-5xl">
        {{ modifiedAffirmation }}
      </h1>
      <Button
        v-if="!exerciseFinished"
        label="Begin Exercise"
        size="lg"
        rounded
        color="success"
        class="mt-4"
        @click.prevent="modalShown = true" />
    </div>
    <Modal v-model="modalShown">
      <AffirmationExercise :progress-id="progressId" @close-modal="modalShown = false" />
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed } from 'vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Button from '../Components/Button.vue'
import Modal from '../Components/Modal.vue'
import AffirmationExercise from '../Components/AffirmationExercise.vue'

const props = defineProps({
  affirmation: Object,
  progressId: [Number, String],
  exerciseFinished: Boolean
})

const modalShown = ref(false)

const modifiedAffirmation = computed(() => props.affirmation?.text.replace(/\{([^}]+)\}/, 'Yvan')
)
</script>
