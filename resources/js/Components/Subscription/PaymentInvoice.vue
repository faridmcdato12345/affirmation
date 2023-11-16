<template>
  <div class="mt-8">
    <h2 class="dark:text-white font-medium">
      Receipts
    </h2>
    <ul class="mt-2 border border-gray-200 rounded-md px-2">
      <li 
        v-for="(invoice, index) in invoices" 
        :key="invoice.id" 
        class="flex items-center justify-between w-ful px-2 py-4"
        :class="{'border-b' : index + 1 !== invoices.length}">
        <p class="text-sm font-medium text-gray-700">
          {{ invoice.date }}
        </p>
        <span class="rounded-full px-4 text-xs py-1 font-medium tracking-wide uppercase" :class="invoice.paid ? 'bg-green-100 text-green-900 ' : 'bg-red-100/90 text-red-900'">
          {{ invoice.paid ? 'Paid' : 'Unpaid' }}
        </span>
        <a :href="`/user/invoice/${invoice.id}`">
          <ArrowDownTrayIcon class="h-5 w-5 cursor-pointer" />
        </a>
      </li>
    </ul> 
  </div>
</template>
<script setup>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/solid'

defineProps({
  invoices: {
    type: [Object, Array],
    default: () => {}
  }
})

</script>