<template>
  <input v-if="!modelValue" id="password" v-model="loginForm.password" type="password" name="password" placeholder="••••••••" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" />
  <input v-else id="password" v-model="loginForm.password" type="text" name="password" placeholder="••••••••" class="bborder border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:border-gray-600  dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" />
</template>
<script setup>
defineProps({
  modelValue: Boolean
})
</script>