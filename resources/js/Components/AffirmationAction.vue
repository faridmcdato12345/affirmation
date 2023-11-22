<template>
  <div>
    <h1 class="font-medium text-2xl text-white">
      What to do?
    </h1>
    <p>Enter or list at least one action that is in line with the given affirmation.</p>
    <p>For example:</p>
    <p>Affirmation: "I am always learning."</p>
    <p>Actions:</p>
    <p>1. Watch youtube video on how to repair computer when blue screen problem appear.</p>
    <p>2. Read books about history.</p>
    <Button 
      :label="'GOT IT!'"
      btn-block
      class="mt-4" 
      color="success"
      @click.prevent="$emit('close-tooltip')" />
  </div>
</template>

<script setup>
import Button from './Button.vue'

defineEmits(['close-tooltip'])
</script>

<style scoped>
p{
  color: #fff;
}
</style>