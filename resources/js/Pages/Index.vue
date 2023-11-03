<template>
  <VOnboardingWrapper 
    v-show="user.show_introduction" 
    ref="wrapper" 
    :steps="homeSteps" 
    class="intro-modal"
    @finish="hideTutorialOnStart">
    <template #default="{ previous, next, step, isFirst, isLast, index }">
      <VOnboardingStep>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-md">
          <div class="px-4 py-5 sm:p-6">
            <div class="">
              <div v-if="step?.content">
                <span class="absolute right-4 top-4 mb-2 mr-2 text-gray-600 dark:text-green-500 font-medium text-xs">{{ `${index + 1} / ${homeSteps?.length}` }}</span>
                <h3 v-if="step.content.title" class="text-lg leading-6 text-gray-900 dark:text-white font-semibold">
                  {{ step.content.title }}
                </h3>
                <div v-if="step.content.description" class="mt-2 max-w-xl text-sm ">
                  <p class="text-gray-500 dark:text-gray-200">
                    {{ step.content.description }}
                  </p>
                </div>
              </div>
              <div class="mt-5 relative flex justify-end gap-x-2">
                <template v-if="!isFirst">
                  <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 font-medium text-black hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 sm:text-sm" @click="previous">
                    Previous
                  </button>
                </template>
                <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-5 py-2 font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm" @click="next">
                  {{ isLast ? 'Finish' : 'Next' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </VOnboardingStep>
    </template>
  </VOnboardingWrapper>
  <AuthenticatedLayout>
    <div class="h-screen flex flex-col items-center justify-center md:max-w-7xl overflow-y-hidden">
      <h1 v-if="props.affirmation != null" id="affirmation" class="px-4 text-4xl md:px-0 md:text-6xl font-medium tracking-tight text-center text-white max-w-5xl">
        {{ modifiedAffirmation }}
      </h1>
      <h1 v-else class="px-4 text-4xl md:px-0 md:text-6xl font-medium tracking-tight text-center text-white max-w-5xl">
        You have completed all the affirmations under the selected category.
      </h1>
      <Button
        id="affirmation-button"
        :label="props.affirmation != null ? (exerciseFinished ? 'Today\'s Exercise Complete' : 'Begin Exercise'): 'Switch Category '"
        size="lg"
        rounded
        color="success"
        class="mt-4"
        @click.prevent="props.affirmation != null ? checkDailyExerciseStatus() : switchCategory()" />
    </div>
    <Modal v-model="modalShown">
      <AffirmationExercise  
        :affirmation="modifiedAffirmation" 
        :progress-id="progressId" 
        @close-modal="modalShown = false" 
        @is-complete="completeModalShown = true" />
    </Modal>
    <Modal v-model="completeModalShown">
      <CompleteCategory />
    </Modal>
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { VOnboardingWrapper, useVOnboarding, VOnboardingStep } from 'v-onboarding'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import Button from '../Components/Button.vue'
import Modal from '../Components/Modal.vue'
import AffirmationExercise from '../Components/AffirmationExercise.vue'
import CompleteCategory from '../Components/Category/CompleteCategory.vue'
import { toast } from '../Composables/useToast'
import { useInsertIndexdb } from '../Composables/useInsertIndexdb'
import { useAppIntro } from '../Composables/useAppIntro'

const props = defineProps({
  affirmation: Object,
  progressId: [Number, String],
  exerciseFinished: Boolean,
  isSubscribed: Boolean,
  isNotify: [Boolean, Number],
  userId: Number
})
const modalShown = ref(false)
const completeModalShown = ref(false)
const wrapper = ref('')

const page = usePage()
const { homeSteps } = useAppIntro()
const { start } = useVOnboarding(wrapper)

const user = computed(() => page.props.auth.user)

const { insertData } = useInsertIndexdb()

localStorage.setItem('isSubcribe', props.isSubscribed)
localStorage.setItem('isNotify', props.isNotify)
localStorage.setItem('userId', props.userId)

const checkDailyExerciseStatus = () => {
  if(props.exerciseFinished) {
    return toast('You\'ve already completed today\'s exercise')
  } 
  modalShown.value = true
}

const switchCategory = () => {
  router.get(route('categories'))
}

const hideTutorialOnStart = () => {
  router.patch(route('intro.hide'))
}

onMounted(() => {
  insertData(props.userId)
  if(user.value.show_introduction) {
    start()
  } 
})

const modifiedAffirmation = computed(() => props.affirmation?.text.replace(/\{([^}]+)\}/, user.value.name))
</script>
<style>
[data-v-onboarding-wrapper] [data-popper-arrow]::before {
  content: '';
  background: var(--v-onboarding-step-arrow-background, white);
  top: 0;
  left: 0;
  transition: transform 0.2s ease-out,visibility 0.2s ease-out;
  visibility: visible;
  transform: translateX(0px) rotate(45deg);
  transform-origin: center;
  width: var(--v-onboarding-step-arrow-size, 10px);
  height: var(--v-onboarding-step-arrow-size, 10px);
  position: absolute;
  z-index: -1;
}


</style>