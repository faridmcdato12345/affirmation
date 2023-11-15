<template>
  <div 
    v-for="plan in plans" 
    :key="plan?.name" 
    class="shadow-sm border border-gray-150 dark:border-gray-500 rounded-md mt-3 bg-white relative dark:bg-gray-900 dark:text-white"
    :class="[
      {'border-2 border-green-500/40 dark:border-green-600 shadow-lg' : plan.name === 'Premium Founder\'s Pricing' } 
    ]">
    <div v-if="yearlyPricing ? plan?.yearly_incentive : plan?.monthly_incentive" class="absolute right-0 top-0 px-3 py-1 rounded-bl-md rounded-tr-md bg-gray-200">
      <p class="font-semibold ">
        {{ yearlyPricing ? plan?.yearly_incentive : plan?.monthly_incentive }}
      </p>
    </div>
    <div class="p-5 flex-[1]">
      <h2 class="font-semibold mt-3 mb-2 dark:text-white">
        {{ plan.name }}
      </h2>
      <p class="font-medium text-base dark:text-white">
        ${{ plan.plan?.price }} / {{ yearlyPricing ? 'yearly' : 'monthly' }}
      </p>
      <p class="mt-3 dark:text-white">
        {{ plan.description }}
      </p>
      <ul class="mt-3">
        <li v-for="(feature, i) in plan.features" :key="i" class="flex items-center gap-x-1">
          <CheckCircleIcon class="h-4 w-4 text-green-600" />
          {{ feature }}
        </li>
      </ul>
    </div>
    <div class="bg-gray-200 dark:bg-gray-700 w-full px-4 py-3 rounded-b-md">
      <div class="flex justify-end">
        <Button 
          label="SUBSCRIBE" 
          size="sm" 
          color="success" 
          class="tracking-wide font-semibold" 
          @click.prevent="emit('subscribe-plan', plan)" />
      </div>
    </div>
  </div>
</template>
<script setup>
import Button from '../../Components/Button.vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'

defineProps({
  plans: {
    type: Object,
    default: () => {}
  },
  yearlyPricing: {
    type: Boolean,
    default: false
  }

})

const emit = defineEmits(['subscribe-plan'])
</script>