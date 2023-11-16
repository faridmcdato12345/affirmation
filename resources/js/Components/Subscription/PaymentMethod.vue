<template>
  <div class="mt-8">
    <h2 class="dark:text-white mt-5 font-medium">
      Payment Methods
    </h2>
    <div class="flex flex-col gap-2 border border-gray-150 bg-white darkbg-gray-900 p-2 rounded-md">
      <div v-for="payment in paymentMethods" :key="payment.id" class="w-full border border-gray-150 rounded-md bg-white dark:text-white dark:bg-gray-900 px-4 py-3">
        <div class="flex items-center gap-x-4 justify-between">
          <div class="flex gap-x-5 items-center">
            <div class="w-7 h-6 bg-white flex items-center">
              <img :src="paymentMethodIcon(payment.card?.brand)" alt="Payment Method Logo" class="object-contain w-full" />
            </div>
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
          <a 
            v-if="payment.id !== defaultPayment.id" 
            href="" 
            type="button" 
            class="text-gray-500 hover:text-blue-600 text-sm tracking-normal font-medium"
            @click.prevent="paymentMethodId = payment.id; confirmDefaultModal = true;">
            Set as default
          </a>
          <TrashIcon 
            v-if="payment.id !== defaultPayment.id" 
            class="w-5 h-5 text-gray-400 hover:text-red-600 transition-colors duration-200 cursor-pointer"
            @click.prevent="paymentMethodId = payment.id; confirmDeleteModal = true" />
        </div>
      </div>
      <div>
        <Button label="Add Payment Method" color="success" @click.prevent="addPaymentMethod" />
      </div>
    </div>

    <Teleport to="body">
      <Modal v-model="confirmDeleteModal">
        <h2 class="dark:text-white">
          Confirm Delete
        </h2>
        <p class="dark:text-gray-300 max-w-md mt-3 font-light text-base">
          Are you sure you want to delete this payment method?
        </p>
        <div class="flex justify-end gap-x-2 mt-4">
          <Button 
            label="Cancel" 
            color="gray" 
            :disabled="isLoading"
            @click.prevent="confirmDeleteModal = false" />
          <Button 
            label="Confirm Delete" 
            color="error" 
            :loading="isLoading"
            @click.prevent="deletePaymentMethod" />
        </div>
      </Modal>

      <!-- Default Payment -->
      <Modal v-model="confirmDefaultModal">
        <h2 class="dark:text-white">
          Set Default
        </h2>
        <p class="dark:text-gray-300 max-w-md mt-3 font-light text-base">
          Are you sure you want to set this as the default payment?
        </p>
        <div class="flex justify-end gap-x-2 mt-4">
          <Button 
            label="Cancel" 
            color="gray" 
            :disabled="isLoading"
            @click.prevent="confirmDefaultModal = false" />
          <Button 
            label="Set as Default" 
            color="success" 
            :loading="isLoading"
            @click.prevent="setDefaultPayment" />
        </div>
      </Modal>
    </Teleport>
  </div>
</template>
<script setup>
import { computed, ref } from 'vue'
import { TrashIcon } from '@heroicons/vue/24/solid'
import { router } from '@inertiajs/vue3'
import Button from '../Button.vue'
import Modal from '../Modal.vue'
import visaLogo from '../../../../public/images/payment-methods/visa-icon.png'
import mcLogo from '../../../../public/images/payment-methods/mc-logo-52.svg'
import amexLogo from '../../../../public/images/payment-methods/american-express.png'
import discoverLogo from '../../../../public/images/payment-methods/discover.png'
import dinersLogo from '../../../../public/images/payment-methods/diners.png'
import unionPayLogo from '../../../../public/images/payment-methods/unionpay.png'
import { toast } from '../../Composables/useToast'

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

const confirmDefaultModal = ref(false)
const confirmDeleteModal = ref(false)
const isLoading = ref(false)
const paymentMethodId = ref('')

const addPaymentMethod = () => {
  router.get(route('payment-method.add'), {}, {
    onSuccess: () => {
      toast.success('Payment Method has been added successfully!')
    },
    onError: () => {
      return toast.error('Can\'t add payment method. Please try again later.')
    }
  })
}

const setDefaultPayment = () => {
  isLoading.value = true
  router.post(route('payment-method.default'), { 
    paymentMethodId: paymentMethodId.value 
  }, {
    onError: () => {
      return toast.error('Can\'t set payment method as default. Please try again later.')
    },
    onFinish: () => {
      isLoading.value = false
      confirmDefaultModal.value = false
    }
  })
}

const deletePaymentMethod = () => {
  isLoading.value = true
  router.post(route('payment-method.delete'), { 
    paymentMethodId: paymentMethodId.value 
  }, {
    onError: () => {
      return toast.error('Can\'t delete payment method. Please try again later.')
    },
    onFinish: () => {
      isLoading.value = false
      confirmDeleteModal.value = false
    }
  })
}

const paymentMethodIcon = (brand) => computed(() => {
  return {
    'visa': visaLogo,
    'mastercard': mcLogo,
    'amex': amexLogo,
    'discover': discoverLogo,
    'diners': dinersLogo,
    'unionpay': unionPayLogo
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