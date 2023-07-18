import { ref, onMounted } from 'vue'

export function useToggleDarkMode() {
  const isDarkMode = ref(JSON.parse(localStorage.getItem('darkMode')) ?? false)
  const htmlEl = ref()

  const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value 
    localStorage.setItem('darkMode', isDarkMode.value)
    htmlEl.value.classList.toggle('dark')
  }
  
  onMounted(() => {
    htmlEl.value = document.querySelector('html')
    if(isDarkMode.value) {
      htmlEl.value.classList.add('dark')
    } else {
      htmlEl.value.classList.remove('dark')
    }
  })

  return { isDarkMode, toggleDarkMode }
}