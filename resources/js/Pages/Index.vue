<template>
  <AuthenticatedLayout background-image="the-river-gfd490d610_1280.jpg">
    <div class="h-screen flex flex-col items-center justify-center md:max-w-7xl mx-auto">
      <h1 class="px-4 text-4xl md:px-0 md:text-6xl font-medium tracking-tight text-center text-white max-w-5xl">
        {{ affirmation.text }}
      </h1>
      <Button label="Begin Exercise" size="lg" rounded color="success" class="mt-4" @click.prevent="modalShown = true" />
    </div>
    <Modal v-model="modalShown">
      <AffirmationExercise :progress-id="progressId" @close-modal="modalShown = false" />
    </Modal>
    <div class="absolute top-4 left-4">
      <Link href="/logout" method="post" as="button" type="button">
        Logout
      </Link>
    </div>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Button from '../Components/Button.vue'
import Modal from '../Components/Modal.vue'
import AffirmationExercise from '../Components/AffirmationExercise.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  affirmation: Object,
  progressId: [Number, String],
})

const modalShown = ref(false)
</script>