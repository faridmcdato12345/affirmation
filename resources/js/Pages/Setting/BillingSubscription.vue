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
          <!-- Notification banner for trial subscription -->
          <div class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2 shadow-sm">
            <p>You are currently with your free trial period. Your trial will expire on Nov 15, 2023.</p>
          </div>

          <ActiveSubscription v-if="packages.activeSubscription" :subscription="packages.activeSubscription" /> 
          <PaymentMethod v-if="packages.paymentMethods" :payment-methods="packages.paymentMethods" :default-payment="packages.defaultPaymentMethod" />

          <div v-if="!packages.activeSubscription" class="flex gap-x-3 mt-4">
            <p class="font-semibold">
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
            <p class="font-semibold">
              YEARLY
            </p>
          </div>

          <CardPlan v-if="!props.packages.activeSubscription" :plans="filteredPlans" :yearly-pricing="yearlyPricing" @subscribe-plan="subscribePlan" /> 
        </div>
      </div>
    </component>
  </div>
</template> 
<script setup>
import { ref, computed } from 'vue'
import { isMobile } from 'mobile-device-detect'
import { router, usePage } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import CardPlan from '../../Components/Subscription/CardPlan.vue'
import PaymentMethod from '../../Components/Subscription/PaymentMethod.vue'
import ActiveSubscription from '../../Components/Subscription/ActiveSubscription.vue'

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

const page = usePage()
const yearlyPricing = ref(false)

console.log('Subscription: ', props.packages.activeSubscription)
console.log('Packages: ', props.packages)
console.log('Payment Method: ', props.packages.defaultPaymentMethod)

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
    onSuccess: (res) => {
      console.log(page)
      console.log({ res })
    }
  })
}
</script>