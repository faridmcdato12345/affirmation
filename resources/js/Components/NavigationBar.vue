<template>
  <Teleport to="body">
    <nav class="bottom-0 left-0 px-4 fixed bg-white pt-3 pb-2 shadow w-full md:rounded-2xl md:mb-12 md:w-[640px] md:left-1/2 md:-translate-x-1/2 md:opacity-90 hover:opacity-100 duration-200 ease-in-out">
      <ul class="flex justify-around items-center mb-0 pl-0">
        <Link
          v-for="link in navLinks" :key="`${link.label}-route`" :href="route(link.link)" 
          class=" hover:bg-blue-100 rounded-full px-4 py-2 duration-200 ease-out"
          :class="isRouteActive(link.link)">
          <li class="flex flex-col items-center cursor-pointer">
            <component :is="link.icon" class="w-6 h-6" />
            {{ link.label }}
          </li>
        </Link>
      </ul>
    </nav>
  </Teleport>
</template>
<script setup>
import { useNavigationLinks } from '../Composables/useNavigationLinks'
import { Link } from '@inertiajs/vue3'
const { navLinks } = useNavigationLinks()

const isRouteActive = (data) => {
  /* eslint-disable */
  return route().current(data)
    ? 'text-blue-500'
    : 'text-gray-500'
}
</script>