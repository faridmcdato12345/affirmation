<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg">
    <div class="flex flex-col items-center justify-center">
      <h1 class="px-4 text-5xl md:px-0 md:text-6xl font-medium tracking-tight text-center text-white max-w-5xl">
        {{ affirmation.text }}
      </h1>
      <Button label="Begin Exercise" size="lg" color="success" class="mt-4" @click.prevent="modalShown = true" />
    </div>
    <Modal v-model="modalShown">
      <AffirmationExercise />
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Button from '../Components/Button.vue'
import Modal from '../Components/Modal.vue'
import AffirmationExercise from '../Components/AffirmationExercise.vue'
defineProps({
  affirmation: Object
})

const modalShown = ref(false)
</script>