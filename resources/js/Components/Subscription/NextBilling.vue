<template>
  <div class="mt-7">
    <h2 class="font-medium text-gray-800">
      Payment
    </h2>
    <div class="w-full md:w-1/2 bg-white shadow-sm border mt-3 rounded-md p-4">
      <p class="text-gray-600 dark:text-gray-300">
        Next Payment <span v-if="nextBillingDate && !onGracePeriod">on {{ nextBillingDate }}</span>
      </p>
      <p v-if="!onGracePeriod && activeSubscription" class="text-lg font-semibold mt-1 text-gray-700 tracking-wide">
        {{ formattedAmount.format(activeSubscription?.amount?.unit_amount / 100) }}
      </p>
      <p v-else class="text-base mt-1 font-medium text-gray-700">
        No Payment Scheduled.
      </p>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  nextBillingDate: {
    type: [Date, String],
    default: ''
  },
  amount: {
    type: [Number, String],
    default: ''
  },
  activeSubscription: {
    type: Object,
    default: () => {}
  },
  onGracePeriod: {
    type: Boolean,
    default: false
  }
})

let formattedAmount = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: props.activeSubscription?.amount?.currency,
})
</script>