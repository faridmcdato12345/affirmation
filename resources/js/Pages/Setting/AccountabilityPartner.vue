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
              <div v-if="!isMobile" class="flex gap-x-2">
                <Button label="Invite" color="success" @click.prevent="inviteModal = true" />
                <Button label="Show QR" color="gray" @click.prevent="qrModal = true" />                
              </div>
            </div>
          </div>
          <div v-if="isMobile" class="flex justify-end gap-x-2">
            <Button label="Invite" color="success" @click.prevent="inviteModal = true" />
            <Button label="Show QR" color="gray" @click.prevent="qrModal = true" />
            <Button label="Scan QR" color="gray" @click.prevent="showQRScanner = !showQRScanner" />
          </div>
          <div v-if="!isMobile" class="flex justify-end">
            <Button label="Scan QR" color="gray" @click.prevent="showQRScanner = !showQRScanner" />
          </div>
          <p v-if="accountabilityPartner.length === 0 && accountabilityRequest.length === 0" class="dark:text-gray-400">
            Get additional support by sending an invite to your friend. Click the invite button to send an invite to your friend by email. Be positive in every possible ways :)
          </p>
          <div v-if="accountabilityPartner.length !== 0" class="flex flex-wrap">
            <div class="mb-4">
              <p class="mt-4 font-medium text-base text-black dark:text-white">
                Personal Partners
              </p>
              <p class="dark:text-gray-300 text-sm">
                Here are the list of users that you've sent request with to be your partner
              </p>
            </div>
            <div v-for="(invite, i) in accountabilityPartner" :key="i" class="flex w-full gap-x-2 items-center justify-between border-t border-b dark:border-gray-600 p-3 md:w-full">
              <div class="flex items-center gap-x-3">
                <div class="h-12 w-12 bg-gray-300 rounded-full"></div>
                <div class="leading-3">
                  <p class="text-base font-medium text-black dark:text-white">
                    {{ invite.requested_user?.name }}
                  </p>
                  <p class="dark:text-gray-400">
                    {{ invite.requested_user?.email }}
                  </p>
                </div>
              </div>
              <div class="leading-4">
                <p class="font-semibold dark:text-gray-300">
                  {{ invite.accepted_at ? 'ACCEPTED' : invite.declined_at ? 'DECLINED' : 'PENDING' }}
                </p>
                <p class="dark:text-gray-300">
                  {{ invite.created_at }}
                </p>
              </div>
              <Button 
                v-if="invite.requested_user.accountability_reminders" 
                label="View Reminder" 
                color="success" 
                size="sm" 
                @click.prevent="toggleReminder(invite.requested_user?.accountability_reminders)" />
              <Button 
                v-if="!invite.accepted_at && !invite.declined_at" 
                label="Cancel" 
                color="gray" 
                size="sm" 
                @click.prevent="toggleCancelInvite(invite.id)" />
            </div>
          </div> 

          <!-- REQUEST SENT TO BE PARTNER -->
          <div v-if="accountabilityRequest.length !== 0" class="flex flex-wrap mt-8">
            <div class="mb-4">
              <p class="font-medium text-base text-black dark:text-white">
                Accountability Partners
              </p>
              <p class="text-sm dark:text-gray-300">
                List of users that sent you a request to be their accountability partner.
              </p>
            </div>
            <div v-for="(requesting, i) in accountabilityRequest" :key="i" class="flex w-1/2 gap-x-2 items-center justify-between border-t border-b dark:border-gray-600 p-3 md:w-full">
              <div class="flex items-center gap-x-3">
                <div class="h-12 w-12 bg-gray-300 rounded-full"></div>
                <div class="leading-3">
                  <p class="text-base font-medium text-black dark:text-gray-300">
                    {{ requesting.requesting_user?.name }}
                  </p>
                  <p class="dark:text-gray-300">
                    {{ requesting.requesting_user?.email }}
                  </p>
                </div>
              </div>
              <div class="leading-4">
                <p class="font-semibold dark:text-gray-300">
                  {{ requesting.accepted_at ? 'APPROVED' : requesting.declined_at ? 'DECLINED' : 'PENDING' }}
                </p>
                <p class="dark:text-gray-300">
                  {{ requesting.created_at }}
                </p>
              </div>
              <div class="flex gap-x-1">
                <Button 
                  v-if="!requesting.accepted_at && !requesting.declined_at" 
                  label="Decline" 
                  color="gray" 
                  size="sm" 
                  @click.prevent="toggleCancelInvite(requesting.id)" />
                <Button 
                  v-if="!requesting.accepted_at && !requesting.declined_at" 
                  label="Approve" 
                  color="success" 
                  size="sm" 
                  @click.prevent="toggleApproveInvite(requesting.id)" />
                <Button 
                  v-else 
                  label="View Status" 
                  color="success" 
                  size="sm" 
                  @click.prevent="toggleAffirmationStatus(requesting.requesting_user)" />
              </div>
            </div>
          </div> 
        </div>
      </div>
    </component>

    <!-- CHECKING OF PARTNER'S AFFIRMATIONS STATUS -->
    <Modal v-model="affirmationStatusModal" max-width="default">
      <div class="mb-4">
        <CheckCircleIcon v-if="affirmationStatus.affirmation_status" class="mx-auto w-12 h-12 text-green-600" />
        <XCircleIcon v-else class="mx-auto w-12 h-12 text-red-600" />
        <h1 v-if="!affirmationStatus.affirmation_status" class="mt-3 dark:text-white text-center">
          Uh Oh! Remind your Friend
        </h1>
        <h1 v-else class="mt-3 dark:text-white text-center">
          Partner is doing Great
        </h1>
        <p v-if="affirmationStatus.affirmation_status" class="text-center text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          It appears that you're friend has already taken the exercise for today. Continue checking on your friend and help each other by giving positivity
        </p>
        <p v-else class="text-center text-base max-w-md mx-auto leading-6 mt-2 font-light">
          Thank you for checking out your partner today. Help your partner by sending a notification with personalized message.
        </p>
      </div>
      <div class="mt-8">
        <Button 
          v-if="!affirmationStatus.affirmation_status"
          label="Send Notification" 
          color="success" 
          btn-block
          @click.prevent="sendReminderModal = true" />
        <Button 
          label="Close" 
          color="gray" 
          btn-block
          class="mt-2"
          @click.prevent="affirmationStatusModal = false" />
      </div>
    </Modal>

    <!-- SENDING INVITE FOR ACCOUNTABILITY PARTNER -->
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

    <Modal v-model="sendReminderModal" max-width="default">
      <div class="mb-4">
        <h1 class="mt-2 dark:text-white">
          Send Reminder
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          Remind and send a personalized message to your accountability partner. 
        </p>
      </div>
      <form @submit.prevent="sendReminder">
        <FormInput
          id="message"
          v-model="form.message"
          label="Message"
          :error="form?.errors.message"
          required />
        <div class="flex items-center justify-center gap-x-2 mt-5">
          <Button 
            label="Cancel" 
            color="gray" 
            btn-block
            :loading="form.processing"
            @click.prevent="sendReminderModal = false" />
          <Button 
            label="Remind Partner" 
            type="submit"
            color="success" 
            btn-block
            :loading="form.processing" />
        </div>
      </form>
    </Modal>

    <Modal v-model="reminderModal" max-width="default">
      <div class="mb-4">
        <h1 class="mt-2 dark:text-white">
          Hi There!
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          {{ reminder?.message }}
        </p>
      </div>
      <div class="mt-7">
        <Button 
          label="Close" 
          color="gray" 
          btn-block
          class="mt-2"
          @click.prevent="updateReminderStatus" />
      </div>
    </Modal>

    <Modal v-model="approveModal" max-width="default">
      <div class="mb-4">
        <h1 class="mt-2 dark:text-white">
          Confirm Approve
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          You can give additional support to this person by accepting this invite. Are you sure you want to accept this?
        </p>
      </div>
      <div class="mt-7">
        <Button 
          label="Accept Invite" 
          color="success" 
          btn-block
          @click.prevent="approveInvite" />
        <Button 
          label="Close" 
          color="gray" 
          btn-block
          class="mt-2"
          @click.prevent="deleteModal = !deleteModal" />
      </div>
    </Modal>

    <Modal v-model="deleteModal" max-width="default">
      <div class="mb-4">
        <h1 class="mt-2 dark:text-white">
          Confirm Cancel
        </h1>
        <p class="text-base max-w-md mx-auto leading-6 mt-2 font-light dark:text-gray-400">
          Are you sure you want to cancel this invite? You may still resend him another request if you want to.
        </p>
      </div>
      <div class="mt-7">
        <Button 
          label="Confirm Cancel" 
          color="error" 
          btn-block
          @click.prevent="cancelInvite" />
        <Button 
          label="Close" 
          color="gray" 
          btn-block
          class="mt-2"
          @click.prevent="deleteModal = !deleteModal" />
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
        <qrcode-vue 
          :value="user.email" 
          :size="300" 
          level="H" 
          :margin="2" />
      </div>
      <div class="flex items-center justify-center gap-x-2 mt-5">
        <Button 
          label="Close" 
          color="success" 
          btn-block
          @click.prevent="qrModal = !qrModal" />
      </div>
    </Modal>

    <QRScanner v-model="showQRScanner" @send-invite="initiateSendInvite" />
  </div>
</template> 
<script setup>
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { isMobile } from 'mobile-device-detect'
import QrcodeVue from 'qrcode.vue'

import AuthenticateMobileSettingLayoutVue from '../../Layouts/AuthenticateMobileSettingLayout.vue'
import Settings from '../Settings.vue'
import Button from '../../Components/Button.vue'
import FormInput from '../../Components/FormInput.vue'
import Modal from '../../Components/Modal.vue'
import QRScanner from '../../Components/Accountability/QRScanner.vue'
import { toast } from '../../Composables/useToast'
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/solid'

defineProps({
  data: {
    type: Object,
    default: () => {}
  },
  accountabilityPartner: {
    type: Object,
    default: () => {}
  },
  accountabilityRequest: {
    type: [Object, Array],
    default: () => []
  }
})

const page = usePage()

const successMessage = computed(() => page.props.flash.success)
const errorMessage = computed(() => page.props.flash.error)
const infoMessage = computed(() => page.props.flash.info)

const form = useForm({ email: '', message: '', user_id: '' })
const inviteModal = ref(false)
const deleteModal = ref(false)
const approveModal = ref(false)
const sendReminderModal = ref(false)
const reminderModal = ref(false)
const qrModal = ref(false)

const affirmationStatusModal = ref(false)
const affirmationStatus = ref(null)
const reminder = ref(null)

const showQRScanner = ref(false)

const userInviteId = ref(null)

const user = computed(() => page.props.auth.user)

const initiateSendInvite = (email) => {
  form.email = email
  sendInvite()
}

const sendInvite = () => {
  form.post(route('setting.accountability.invite'), {
    onSuccess: () => {
      toast.success(successMessage.value ?? infoMessage.value)
      inviteModal.value = false
    },
    onError: () => {
      toast.error(errorMessage.value ?? 'Invite is invalid. Please try again')
      inviteModal.value = false
    }
  })
}

const toggleAffirmationStatus = (data) => {
  affirmationStatus.value = data
  affirmationStatusModal.value = true
}

const toggleCancelInvite = (inviteId) => {
  userInviteId.value = inviteId
  deleteModal.value = true
}

const toggleApproveInvite = (inviteId) => {
  userInviteId.value = inviteId
  approveModal.value = true
}

const toggleReminder = (data) => {
  reminder.value = data
  reminderModal.value = true
}

const cancelInvite = () => {
  form.delete(route('setting.accountability.delete', userInviteId.value ), {
    onSuccess: () => {
      toast.success(successMessage.value ?? infoMessage.value)
      deleteModal.value = false
    },
    onFinish: () => {
      userInviteId.value = ''
      deleteModal.value = false
      form.reset()
    }
  })
}

const approveInvite = () => {
  form.patch(route('setting.accountability.approve', userInviteId.value), {
    onSuccess: () => {
      toast.success(successMessage.value ?? infoMessage.value)
      approveModal.value = false
    },
    onFinish: () => {
      userInviteId.value = ''
      approveModal.value = false
      form.reset()
    }
  })
}

const sendReminder = () => {
  form.user_id = affirmationStatus.value.id

  form.post(route('setting.accountability.remind'), {
    onSuccess: () => {
      toast.success(successMessage.value ?? infoMessage.value)
      sendReminderModal.value = false
    },
    onError: () => {
      toast.success(errorMessage.value)
    },
    onFinish: () => {
      userInviteId.value = ''
      sendReminderModal.value = false
      form.reset()
    }
  })
}

const updateReminderStatus = () => {
  form.patch(route('setting.reminder.read', reminder.value.id), {
    onSuccess: () => {
      reminderModal.value = false
    },
    onError: () => {
      toast.success(errorMessage.value)
    },
    onFinish: () => {
      reminderModal.value = false
      reminder.value = null
      form.reset()
    }
  })
}

</script>