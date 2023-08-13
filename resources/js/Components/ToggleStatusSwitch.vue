<template>
  <label class="switch">
    <input type="checkbox" :checked="props.notifiable == 1" @click="toggleSwitch" />
    <span class="slider round"></span>
  </label>
</template>
<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { toast } from '../Composables/useToast'


const props = defineProps({
  notifiable: Boolean,
  reminder: Object
})
let form = useForm({
  status: ''
})
const disallow = ref(props.notifiable == 1 ? true : false)
watch(() => props.reminder, () => {
  form = useForm({...props.reminder})
  console.log('Forms: ', form)
})
const toggleSwitch = () => {
  disallow.value = !disallow.value
  form = useForm({
    status: disallow.value
  })
  form.patch(route('setting.reminder.status.update',props.reminder.id),{
    onSuccess: () => {
      toast.success('Status has been updated!')
    },
    onError: () => {
      if(form.errors) {
        toast.error('Something went wrong!')
      }
    }
  })
}
</script>
<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
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
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
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
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>