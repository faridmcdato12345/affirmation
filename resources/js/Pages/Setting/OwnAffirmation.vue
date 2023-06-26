<template>
  <Settings v-if="!isMobile">
    <div class="w-full pl-16 pr-8 py-16 h-full overflow-scroll">
      <form @submit.prevent="save">
        <div class="mb-12 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green">
            Own Affirmation
          </h1>
        </div>
        <div class="mb-12">
          <h4 class="text-theme-green">
            Write your own affirmation
          </h4>
        </div>
        <div class="flex">
          <div class="w-[90%]">
            <FormInput id="affirmation" v-model="formValues[0]" label="Affirmation" type="text" autofocus />
          </div>
          <div class="w-[10%] flex justify-center items-center">
            <PlusCircleIcon class="w-14 mx-auto text-green-600" @click="addInput" />
          </div>
        </div>
        <div
          v-for="(input, index ) in inputs" 
          :key="index"
          class="flex">
          <div class="w-[90%]">
            <FormInput id="affirmation" v-model="formValues[index + 1]" label="Affirmation" type="text" :name="'input-' + index + 1" />
          </div>
          <div class="w-[10%] flex justify-center items-center">
            <PlusCircleIcon class="w-14 mx-auto text-green-600" @click="addInput" />
          </div>
        </div>
        <br />
        <Button label="Save Changes" />
      </form>
    </div>
    <Modal v-model="modal">
      <div class="text-center">
        <component 
          :is="modalIcon ? CheckCircleIcon : XCircleIcon" 
          class="w-14 mx-auto text-green-600 duration-200 ease-out" />
        <!-- <CheckCircleIcon class="w-14 mx-auto text-green-600" /> -->
        <h1 class="mt-2">
          {{ modalTextHeader }}
        </h1>
        <p class="text-lg max-w-md mx-auto leading-6 mt-2 font-light">
          {{ modalTextBody }}
        </p> 
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-4">
        <Button label="Cancel" color="error" @click.prevent="modal = false" />
      </div>
    </Modal>
  </Settings>
</template>
<script setup>
import { ref,reactive } from 'vue'
import { isMobile } from 'mobile-device-detect'
import { useForm } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import Button from '../../Components/Auth/Button.vue'
import FormInput from '../../Components/FormInput.vue'
import Modal from '../../Components/Modal.vue'
import { PlusCircleIcon, CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/solid'

const inputs = ref([])
const formValues = reactive({})


const addInput = () => {
  const newIndex = inputs.value.length
  inputs.value.push(newIndex + 1)
  formValues[newIndex + 1] = ''
}
console.log(formValues)
const form = useForm({
  affirmation: [],
})
const modal = ref(false)
const modalTextHeader = ref('')
const modalTextBody = ref('')
const modalIcon = ref(true)

const save = () => {
  const formData = { ...formValues }
  form.affirmation = formData
  // useForm.submit(formData).then(() => {
  //   form.post(route('setting.useraffirmation.store'),formData)
  // })
  form.post(route('setting.useraffirmation.store'),
    {
      onSuccess: () => {
        modal.value = true,
        modalTextBody.value = 'Successfully added your own affirmation',
        modalTextHeader.value = 'Success!'
      }
    }
  )
}
</script>