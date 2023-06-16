<template>
  <div>
    <div>
      <p class="text-base mt-4 text-gray-700">
        On a scale of 1 to 5 (1 being the lowest) how do you feel today?
      </p>
      <rate v-model="rating.happiness_score" :length="5" />
    </div>
    <div>
      <p class="text-base mt-4 text-gray-700">
        On a scale of 1 to 5 (1 being the lowest) how much does this affirmation fit with you?
      </p>
      <rate v-model="rating.belief_score" :length="5" />
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const rating = computed({
  get() {
    return props.modelValue
  },
  set(val) {
    emit('update:modelValue', val)
  }
})

</script>
<style>
.Rate .icon {
  width: 30px;
  height: 30px ;
}
</style>