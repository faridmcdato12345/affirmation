<template>
  <label class="switch">
    <input 
      type="checkbox" 
      :checked="props.notifiable == 1" 
      class="peer"
      @click="toggleSwitch" />
    <span class="slider round"></span>
  </label>
</template>
<script setup>
import { ref } from 'vue'
const emit = defineEmits(['toggleCheckbox'])

const props = defineProps({
  notifiable: Boolean
})

const disallow = ref(props.notifiable == 1 ? true : false)
const toggleSwitch = () => {
  disallow.value = !disallow.value
  emit('toggleCheckbox',disallow.value)
}

</script>
<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 2px;
  background-color: #8ABE53;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #096A2E;
}

input:focus + .slider {
  box-shadow: 0 0 1px #096A2E;
}

input:checked + .slider:before {
  -webkit-transform: translateX(24px);
  -ms-transform: translateX(24px);
  transform: translateX(24px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
@media screen and (max-width: 480px) {
  .slider:before {
    left: 2px;
  }

  input:checked + .slider:before {
    left: 0px;
    transform: translateX(28px);
    -webkit-transform: translateX(28px);
    -ms-transform: translateX(28px);
  }
}
</style>