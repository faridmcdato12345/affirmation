<template>
  <AuthenticatedLayout>
    <form @submit.prevent="sendNotif">
      <FormInput id="input1" v-model="form.title" label="title" required type="text" :error="form.errors.title" />
      <FormInput id="input2" v-model="form.body" label="body" required type="text" :error="form.errors.body" />
      <Button label="Save" type="submit" color="success" />
    </form>   
  </AuthenticatedLayout>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import FormInput from '../Components/FormInput.vue'
import { toast } from '../Composables/useToast.js'
import Button from '../Components/Button.vue'
import { initializeApp } from '@firebase/app'
import { getMessaging, onMessage  } from '@firebase/messaging'

const form = useForm({
  title:'',
  body: ''
})

const sendNotif = () => {
  form.post(route('send.notification'),{
    onSuccess: () => {
      form.reset()
      toast.success('Time has been added successfully!')
    },
    onError: () => {
      toast.error(form.errors.error ?? 'Fields are required')
    }
  })
}
const firebaseConfig = {
  apiKey: 'AIzaSyCDL5jn4IThej6gpOILzj8XmrzOFMRn0H0',
  authDomain: 'affirm-7b375.firebaseapp.com',
  projectId: 'affirm-7b375',
  storageBucket: 'affirm-7b375.appspot.com',
  messagingSenderId: '629732409638',
  appId: '1:629732409638:web:48727d1382c07824e941e7',
  measurementId: 'G-G2NDWXEH44'
}
const app = initializeApp(firebaseConfig)

const messaging = getMessaging(app)
//const token = getToken(messaging, {vapidKey: 'BMa-Lyz6AeLZX31Ts0UdZBtTKCWqx1q73EQ_MEUJRxM7AXz31CF27BEYFaoBSlY0Koa52mkT3l10TIf9Il2eSEw'})


onMessage(messaging, (payload) => {
  // const noteTitle = payload.notification.title;
  // const noteOptions = {
  //     body: payload.notification.body,
  // };
  // new Notification(noteTitle, noteOptions);
})
</script>