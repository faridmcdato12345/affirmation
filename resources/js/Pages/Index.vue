<template>
  <VOnboardingWrapper v-show="user.show_introduction" ref="wrapper" :steps="homeSteps" @finish="hideTutorialOnStart">
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
   
    <!-- UPGRADE MODAL -->
    <Modal v-model="showUpgradeModal" max-width="default" persistent>
      <div class="py-2 flex gap-x-5">
        <div class="mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-green-600 w-10 h-10">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
          </svg>
        </div>
        <div>
          <h1 class="mt-2 dark:text-white text-xl">
            Hey There!
          </h1>
          <p class="dark:text-gray-200 text-base x-auto leading-6 mt-2 max-w-sm text-">
            Are you enjoying this application? Unlock exclusive features: more affirmations, custom backgrounds, 
            scheduled notifications, and more by subscribing to our premium plan.
          </p>
        </div>
      </div>
      <div class="flex items-center justify-end gap-x-2 mt-4">
        <Button label="Close" color="gray" component-type="link" @click.prevent="hideModal" />
        <Button component-type="link" label="Subscribe to Premium" color="success" @click.prevent="redirectToUpgrade" />
      </div>
    </Modal> 
  </AuthenticatedLayout>
</template>
<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { VOnboardingWrapper, useVOnboarding, VOnboardingStep } from 'v-onboarding'
import { useCookie } from 'vue-cookie-next'

import Modal from '../Components/Modal.vue'
import Button from '../Components/Button.vue'
import { toast } from '../Composables/useToast'
import { useAppIntro } from '../Composables/useAppIntro'
import { useInsertIndexdb } from '../Composables/useInsertIndexdb'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import AffirmationExercise from '../Components/AffirmationExercise.vue'
import CompleteCategory from '../Components/Category/CompleteCategory.vue'

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
const showUpgradeModal = ref(false)
const wrapper = ref('')

const page = usePage()
const { homeSteps } = useAppIntro()
const { start } = useVOnboarding(wrapper)
const { setCookie, getCookie } = useCookie()

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
  
  setTimeout(() => {
    promptUserUpgrade()
  }, 2000)

  showInviteMessage()
})

const showInviteMessage = async () => {
  await nextTick()
  if (page.props.flash.success) return toast.success(page.props.flash.success)
  if (page.props.flash.error) return toast.error(page.props.flash.error)
}

const hideModal = () => {
  showUpgradeModal.value = false
  setCookie('upgradeModalShown', true, { expire: '3d' })
}

const promptUserUpgrade = () => {
  if (props.isSubscribed) return
  if (user.value.show_introduction) return 

  const cookie = getCookie('upgradeModalShown')
  if(!cookie) {
    showUpgradeModal.value = true
  }
}

const redirectToUpgrade = () => {
  hideModal()
  router.get(route('setting.subscribe'))
}

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