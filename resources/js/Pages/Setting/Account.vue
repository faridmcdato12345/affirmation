<template>
  <Settings>
    <div class="w-full pl-16 pr-8 py-16 h-full">
      <form @submit.prevent="save">
        <div class="mb-12 border-b-2 border-hover-theme-green pb-8">
          <h1 class="text-theme-green">
            Account Settings
          </h1>
        </div>
        <div class="mb-12">
          <h4 class="text-theme-green">
            Personal Information
          </h4>
        </div>
        <FormInput id="fullname" v-model="form.name" label="Full Name" type="text" />
        <br />
        <FormInput id="email" v-model="form.email" type="email" label="Email Address" />
        <br />
        <Button label="Save Changes" />
      </form>
    </div>
  </Settings>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import Settings from '../Settings.vue'
import Button from '../../Components/Auth/Button.vue'
import FormInput from '../../Components/FormInput.vue'

const props = defineProps({
  user: Object
})
const form = useForm({
  name: props.user.name,
  email: props.user.email
})

const save = () => {
  form.patch(route('setting.user.update',props.user.id))
}
</script>