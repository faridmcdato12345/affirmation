<template>
  <AuthLayout>
    <Register :redirect-to="queryParams.redirectTo" />
  </AuthLayout>
</template>
<script setup>
import AuthLayout from '../../Layouts/Auth.vue'
import Register from '../../Components/Auth/Form/Register.vue'

defineProps({
  queryParams: [Object, String]
})

</script>
<style scoped>

</style>