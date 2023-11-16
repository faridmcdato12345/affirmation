<template>
  <div>
    <h3 class="font-medium mt-4 tracking-normal dark:text-white text-gray-800">
      Active Subscription
    </h3>
    <div class="border-2 border-green-500/40 dark:border-green-600 rounded-md mt-3 bg-white relative dark:bg-gray-900 dark:text-white">
      <div class="p-5 flex-[1]">
        <h2 class="font-medium mt-1 mb-2">
          {{ subscription?.plan.name }}
        </h2>
        <p>{{ subscription?.plan?.description }}</p>
        <ul class="mt-3">
          <li v-for="(feature, i) in subscription?.plan?.features" :key="i" class="flex items-center gap-x-1">
            <CheckCircleIcon class="h-4 w-4 text-green-600" />
            {{ feature }}
          </li>
        </ul>
        <div v-if="!subscription.onGracePeriod" class="mt-2 font-medium flex md:items-center gap-x-2">
          <ExclamationCircleIcon class="h-4 w-4 text-blue-500" />
          <p class="leading-5">
            Your <span class="font-semibold">default payment</span> method will be charged automatically for each billing period
          </p>
        </div>
        <p v-if="subscription.onGracePeriod" class="flex gap-x-1 items-center mt-3 font-medium">
          <ExclamationCircleIcon class="h-4 w-4 text-blue-500" />
          Your subscription is still active until {{ getFormattedDate(subscription.ends_at) }}
        </p>
      </div>
      <div class="w-full bg-gray-200 px-4 py-2 flex justify-end gap-x-2">
        <div 
          v-if="!subscription.onGracePeriod" 
          :disabled="isLoading" 
          class="flex items-center hover:bg-gray-300 rounded-md transition-all duration-300 cursor-pointer px-4" @click.prevent="showModal('cancel')">
          <p>Cancel Subscription</p>
        </div>
        <Button 
          v-if="!subscription.onGracePeriod"
          label="Change Subscription" 
          color="success" 
          class="tracking-normal" 
          @click.prevent="emit('change-subscription')" />
        <Button 
          v-if="subscription.onGracePeriod"
          label="Resume Subscription" 
          color="success" 
          class="tracking-normal" 
          :disabled="isLoading"
          @click.prevent="showModal('resume')" />
      </div>
    </div>

    <!-- Confirm Modal -->
    <Teleport to="body">
      <Modal v-model="confirmModal" max-width="sm">
        <div class="py-2">
          <h2 class="dark:text-white">
            {{ modalConfirm.title }}
          </h2>
          <p class="text-sm mt-3 font-light dark:text-gray-500 max-w-md">
            {{ modalConfirm.message }}
          </p>
          <div class="flex justify-end gap-x-2 mt-6">
            <Button 
              label="Cancel"
              color="gray" 
              :disabled="isLoading"
              @click.prevent="confirmModal = false" />
            <Button 
              :label="confirmModalType === 'cancel' ? 'Cancel Subscription' : 'Resume Subscription'"
              color="success" 
              :loading="isLoading"
              @click.prevent="handleAction" />
          </div>
        </div>
      </Modal>
    </Teleport>
  </div>
</template>
<script setup>
import { ref, watch, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { 
  CheckCircleIcon, 
  ExclamationCircleIcon 
} from '@heroicons/vue/24/solid'
import { useToast } from 'vue-toastification'
import Button from '../Button.vue'
import Modal from '../Modal.vue'

defineProps({
  subscription: {
    type: Object,
    default: () => {}
  }
})

const toast = useToast()

const isLoading = ref(false)
const confirmModal = ref(false)
const confirmModalType = ref('')
const modalConfirm = reactive({
  title: '',
  message: ''
})

const emit = defineEmits(['change-subscription'])

const cancelSubscription = () => {
  isLoading.value = true
  router.post(route('subscription.cancel'), {}, {
    onSuccess: () => {  
      return toast.info('Subscription has been cancelled')
    },
    onError: () => {
      return toast.error('Something went wrong. Please contact the support')
    },
    onFinish: () => {
      isLoading.value = false
      confirmModal.value = false
    }
  })
}

const resumeSubscription = () => {
  isLoading.value = true
  router.post(route('subscription.resume'), {}, {
    onSuccess: () => {  
      return toast.success('Subscription has been resumed')
    },
    onError: () => {
      return toast.error('Something went wrong. Please contact the support')
    },
    onFinish: () => {
      isLoading.value = false
      confirmModal.value = false
    }
  })
}

const handleAction = () => {
  if (confirmModalType.value === 'cancel') return cancelSubscription()
  if (confirmModalType.value === 'resume') return resumeSubscription()
}

const showModal = (type) => {
  confirmModalType.value = type 
  confirmModal.value = true
}

const getFormattedDate = (date) => {
  const endDate = new Date(date)
  return `${getMonthLabel(endDate.getMonth())} ${endDate.getDate()}, ${endDate.getFullYear()}` 
}

const getMonthLabel = (month) => {
  return {
    0: 'January',
    1: 'February',
    2: 'March',
    3: 'April',
    4: 'May',
    5: 'June',
    6: 'July',
    7: 'August',
    8: 'September',
    9: 'October',
    10: 'November',
    11: 'December',
  }[month]
}

watch(() => confirmModalType.value, (modalType) => {
  if(modalType === 'cancel') {
    modalConfirm.title = 'Confirm Cancel'
    modalConfirm.message = 'Are you sure you want to cancel your current subscription? You will still have the option to resume it until the end of your current billing cycle.'
  }

  if(modalType === 'resume') {
    modalConfirm.title = 'Confirm Resume'
    modalConfirm.message = 'You can instantly reactivate your subscription at any time until the end of your current billing cycle. After your current billing cycle ends, you may choose an entirely new subscription plan.'
  }
})

</script>