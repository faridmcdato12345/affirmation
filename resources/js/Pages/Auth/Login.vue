<!-- eslint-disable vue/no-export-in-script-setup -->
<template>
  <AuthLayout>
    <LoginForm />
  </AuthLayout>
</template>
<script setup>
import AuthLayout from "../../Layouts/Auth.vue"
import LoginForm from "../../Components/Auth/Form/Login.vue"
</script>
<style scoped>
</style>