<template>
  <div>
    <h2 class="dark:text-white mt-4 font-medium">
      Payment Methods
    </h2>
    <div v-for="payment in paymentMethods" :key="payment.id" class="border border-gray-150 rounded-md mt-3 bg-white dark:text-white dark:bg-gray-900 px-4 py-3">
      <div class="flex items-center gap-x-4 justify-between">
        <div class="flex gap-x-5 items-center">
          <img :src="paymentMethodIcon(payment.card.brand)" alt="Payment Method Logo" class="h-3" />
          <div class="leading-4">
            <div class="flex gap-x-1 text-gray-700 text-sm">
              <p class="text-gray-700">
                {{ payment.card?.brand.charAt(0).toUpperCase() + payment.card?.brand.slice(1) }}
              </p>
              <span>Ending in</span>
              <p class="text-gray-700">
                {{ payment.card?.last4.padStart('8', '*') }}
              </p>
            </div>
            <p>Expires on {{ getMonth(payment.card.exp_month) }} {{ payment.card.exp_year }}</p>
          </div>
        </div>
        <div v-if="payment.id === defaultPayment.id" class="bg-gray-200 px-3 py-1 rounded-full text-xs">
          <p>Default</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import visaLogo from '../../../../public/images/payment-methods/visa-icon.png'
// import mcLogo from '../../../../public/images/payment-methods/mc-logo-52.svg'
// import americanExpressLogo from '../../../../public/images/payment-methods/american-express.png'

defineProps({
  paymentMethods: {
    type: Object,
    default: () => {}
  },
  defaultPayment: {
    type: Object,
    default: () => {}
  }
})

const paymentMethodIcon = (brand) => computed(() => {
  return {
    'visa': visaLogo,
  }[brand]
}).value

const getMonth = month => computed(() => {
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
}).value
</script>