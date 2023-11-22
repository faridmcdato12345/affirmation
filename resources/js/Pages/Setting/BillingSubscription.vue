<template>
  <div>
    <component :is="isMobile ? AuthenticateMobileSettingLayoutVue : Settings" route-name="Login History">
      <div :class="isMobile ? 'w-full h-full p-4' : ''">
        <div class="md:w-full md:pl-12 md:pr-8 md:py-16 h-full">
          <div class="mb-5 border-b-2 border-hover-theme-green pb-5">
            <div class="flex justify-between items-center">
              <div>
                <h1 class="dark:text-white text-theme-green">
                  Affirm Billing
                </h1>
                <p class="dark:text-gray-300">
                  Allows you to conveniently manage your subscription plan, payment methods, and download your recent invoices.
                </p>
              </div>
            </div>
          </div>

          <div v-if="!packages.activeSubscription || selectPlan" class="flex gap-x-3 mt-4 items-center justify-between">
            <a v-if="selectPlan" href="#" type="button" class="text-gray-700 underline-offset-2 hover:text-gray-800 dark:text-gray-200" style="text-decoration: underline !important;" @click.prevent="selectPlan = false">
              Nevermind, I'll keep my old plan
            </a>
            <div class="flex gap-x-3">
              <p class="font-semibold dark:text-gray-200">
                MONTHLY
              </p>
              <label class="relative inline-flex items-center cursor-pointer">
                <input
                  type="checkbox"
                  class="sr-only peer"
                  :checked="yearlyPricing"
                  @click="yearlyPricing = !yearlyPricing" />
                <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-green-500/40 dark:peer-focus:ring-green-800 dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2.5px] after:left-[2px] peer-checked:after:left-[5px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
              </label>
              <p class="font-semibold dark:text-gray-200">
                YEARLY
              </p>
            </div>
          </div>

          <CardPlan 
            v-if="!packages.activeSubscription || selectPlan" 
            :plans="filteredPlans" 
            :yearly-pricing="yearlyPricing"
            :active-subscription-id="packages.activeSubscription?.stripe_price" 
            @subscribe-plan="subscribePlan" /> 

          <ActiveSubscription 
            v-if="packages.activeSubscription && !selectPlan" 
            :subscription="packages.activeSubscription" 
            @change-subscription="selectPlan = true" /> 

          <PaymentMethod 
            v-if="packages.paymentMethods.length > 0" 
            :payment-methods="packages.paymentMethods" 
            :default-payment="packages.defaultPaymentMethod" />

          <NextBilling 
            :next-billing-date="packages.activeSubscription?.currentPeriodEnd" 
            :active-subscription="packages.activeSubscription" 
            :amount="packages.activeSubscription"
            :on-grace-period="packages.activeSubscription?.onGracePeriod" />

          <PaymentInvoice v-if="packages.activeSubscription" :invoices="packages.invoices" />
        </div>
      </div>
    </component>
  </div>
</template> 
<script setup>
import { ref, computed } from 'vue'
import { isMobile } from 'mobile-device-detect'
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'

import Settings from '../Settings.vue'
import CardPlan from '../../Components/Subscription/CardPlan.vue'
import PaymentMethod from '../../Components/Subscription/PaymentMethod.vue'
import PaymentInvoice from '../../Components/Subscription/PaymentInvoice.vue'
import ActiveSubscription from '../../Components/Subscription/ActiveSubscription.vue'
import AuthenticateMobileSettingLayoutVue from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import NextBilling from '../../Components/Subscription/NextBilling.vue'

const props = defineProps({
  packages: {
    type: Object,
    default: () => {}
  },
  checkoutUrl: {
    type: String,
    default: ''
  },
  subscription: {
    type: Object,
    default: () => {}
  },
  paymentMethods: {
    type: Object, 
    default: () => {}
  }
})

const toast = useToast()
const selectPlan = ref(false)
const yearlyPricing = ref(false)

const filteredPlans = computed(() => ({
  ...props.packages.plans?.map(plan => ({
    ...plan,
    plan: {
      plan_id: yearlyPricing.value ? plan.item?.yearly?.id : plan.item?.monthly?.id,
      price: yearlyPricing.value ? (plan.item.yearly?.unit_amount / 100) : (plan.item.monthly?.unit_amount / 100)
    }  
  })),
}))

const subscribePlan = (plan) => {
  router.post(route('checkout'), {
    plan_name: plan.name,
    plan_id: plan.plan.plan_id
  }, {
    onSuccess: () => {
      if(selectPlan.value) {
        selectPlan.value = false
        return toast.success('Subscription has been updated successfully!')
      }
      toast.success('Thank you for subscribing to premium!')
    },
    onError: () => {
      toast.error('Something went wrong! Please contact the support')
    }
  })
}
</script>