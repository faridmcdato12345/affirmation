import { ref, onMounted } from 'vue'

export default function useIPhoneDetector() {
  const isIPhone = ref(false)

  const detectIPhone = () => {
    const userAgent = navigator.userAgent
    isIPhone.value = /iPhone/i.test(userAgent)
  }

  onMounted(() => {
    detectIPhone()
  })

  return {
    isIPhone
  }
}