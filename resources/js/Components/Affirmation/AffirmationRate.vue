<template>
  <div>
    <div>
      <p class="text-base mt-4 text-gray-700">
        On a scale of 1 to 5 (1 being the lowest) how do you feel today?
      </p>
      <!-- <rate v-model="formData.happinessScore" :length="5" /> -->
    </div>
    <div>
      <p class="text-base mt-4 text-gray-700">
        On a scale of 1 to 5 (1 being the lowest) how much does this affirmation fit with you?
      </p>
      <!-- <rate v-model="formData.beliefScore" :length="5" /> -->
    </div>
  </div>
</template>
<script setup>
defineProps({
  formData: Object
})
</script>
<style>
.Rate .icon {
  width: 30px;
  height: 30px ;
}
</style>