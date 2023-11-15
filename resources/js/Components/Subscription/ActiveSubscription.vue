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
        <p v-if="!subscription.onGracePeriod" class="mt-2 font-medium flex items-center gap-x-1">
          <ExclamationCircleIcon class="h-4 w-4 text-blue-500" />
          Your <span class="font-semibold">default payment</span> method will be charged automatically for each billing period.
        </p>
        <p>Your subscription is still active until {{ subscription.ends_at }}</p>
      </div>
      <div class="w-full bg-gray-200 px-4 py-2 flex justify-end gap-x-2">
        <Button 
          v-if="!subscription.onGracePeriod"
          label="cancel Subscription" 
          size="sm" 
          color="gray" 
          class="tracking-normal" 
          @click.prevent="confirmModal = true" />
        <Button 
          v-if="!subscription.onGracePeriod"
          label="Change Subscription" 
          size="sm" 
          color="success" 
          class="tracking-normal" 
          @click.prevent="emit('change-subscription')" />
        <Button 
          v-if="!subscription.onGracePeriod"
          label="Resume Subscription" 
          size="sm" 
          color="success" 
          class="tracking-normal" 
          :loading="isLoading"
          @click.prevent="emit('change-subscription')" />
      </div>
    </div>

    <!-- Confirm Modal -->
    <Teleport to="body">
      <Modal v-model="confirmModal" max-width="sm">
        <div class="py-2">
          <h2 class="dark:text-white">
            Confirm Cancel
          </h2>
          <p class="text-sm mt-2 font-light dark:text-gray-400 max-w-md">
            Are you sure you want to cancel your current subscription? You will still have the option to resume it until the end of your current billing cycle.
          </p>
          <div class="flex justify-end gap-x-2 mt-6">
            <Button 
              label="Cancel"
              color="gray" 
              :disabled="isLoading"
              @click.prevent="confirmModal = false" />
            <Button 
              label="Cancel Subscription"
              color="success" 
              :loading="isLoading"
              @click.prevent="cancelSubscription" />
          </div>
        </div>
      </Modal>
    </Teleport>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Button from '../Button.vue'
import Modal from '../Modal.vue'
import { CheckCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  subscription: {
    type: Object,
    default: () => {}
  }
})

const isLoading = ref(false)
const confirmModal = ref(false)

const emit = defineEmits(['change-subscription'])

console.log(props.subscription.onGracePeriod)

const cancelSubscription = () => {
  isLoading.value = true
  router.post(route('subscription.cancel'), {}, {
    onSuccess: () => {  
      console.log('Hello World!')
    },
    onError: () => {
      console.log('Something went wrong')
    },
    onFinish: () => {
      isLoading.value = false
    }
  })
}

</script>