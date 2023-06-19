<template>
  <Link
    :href="route('login')"
    class="text-center w-full lg:mt-1 md:mt-1 hidden sm:hidden lg:block items-center px-5 py-2.5 bg-pink-700 dark:bg-pink-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest hover:bg-pink-600 dark:hover:bg-pink-600 focus:bg-pink-600 dark:focus:bg-pink-600 active:bg-pink-600 dark:active:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-700 focus:ring-offset-2 dark:focus:ring-offset-pink-700 transition ease-in-out duration-150">
    Cancel
  </Link>
</template>
<script setup>
import {Link
} from '@inertiajs/vue3'
</script>