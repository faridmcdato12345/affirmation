<template>
  <div>
    <p class="text-blue-500 font-semibold">
      Hello World!
    </p>
    <Link :href="route('inertia-login')">
      Navigate to Login with progress
    </Link>
    <p>Helo</p>
  </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3"
</script>
