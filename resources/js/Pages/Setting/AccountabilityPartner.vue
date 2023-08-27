<template>
  <div>
    <component :is="isMobile ? AuthenticateMobileSettingLayoutVue : Settings" route-name="Login History">
      <div :class="isMobile ? 'w-full h-full p-4' : ''">
        <div class="md:w-full md:pl-12 md:pr-8 md:py-16 h-full">
          <div class="mb-5 border-b-2 border-hover-theme-green pb-5">
            <div class="flex justify-between items-center">
              <div>
                <h1 class="dark:text-white text-theme-green">
                  Accountability Partner
                </h1>
                <p class="dark:text-gray-300">
                  Get additional support/help from the people below
                </p>
              </div>
              <div class="flex gap-x-2">
                <Button label="Invite" color="success" @click.prevent="inviteModal = true" />
                <Button label="Show QR" color="gray" @click.prevent="qrModal = true" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </component>

    <Modal v-model="inviteModal" max-width="default">
      <div class="mb-4">
        <h1 class="mt-2 dark:text-white">
          Accountability Partner
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          Invite your friend or anybody as your accountability partner to get more support
        </p>
      </div>
      <FormInput 
        id="email" 
        v-model="form.email" 
        type="email" 
        label="Email Address" 
        :error="form?.errors.email"
        required />
      <div class="flex items-center justify-center gap-x-2 mt-5">
        <Button 
          label="Send Invite" 
          color="success" 
          btn-block
          :loading="form.processing"
          @click.prevent="sendInvite" />
      </div>
    </Modal>

    <Modal v-model="qrModal" max-width="default">
      <div class="mb-4">
        <h1 class="mt-2 dark:text-white">
          QR Code
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          Give additional support to your friends. Let them add you as accountability partner.
        </p>
      </div>
      <div class="flex justify-center">
        <qrcode-vue :value="value" :size="300" level="H" :margin="2" />
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-5">
        <Button 
          label="Close" 
          color="success" 
          btn-block
          @click.prevent="qrModal = !qrModal" />
      </div>
    </Modal>
  </div>
</template> 
<script setup>
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'
import { toast } from '../../Composables/useToast'
import AuthenticateMobileSettingLayoutVue from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import Settings from '../Settings.vue'
import Button from '../../Components/Button.vue'
import FormInput from '../../Components/FormInput.vue'
import Modal from '../../Components/Modal.vue'
import QrcodeVue from 'qrcode.vue'

const props = defineProps({
  data: {
    type: Object,
    default: () => {}
  }
})

const form = useForm({
  email: ''
})
const inviteModal = ref(false)
const qrModal = ref(false)

onMounted(() => {
  console.log('Props: ', props)
})

const sendInvite = () => {
  form.post(route('accountability.invite'), {
    onSuccess: () => {
      toast.success('Invite has been sent successfully!')
      inviteModal.value = false
    }
  })
}

</script>