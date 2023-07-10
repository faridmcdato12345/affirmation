<template>
  <div class="">
    <slot name="header"></slot>
    <Link
      v-for="link in settingNavLinks"
      :key="`${link.label}-route`"
      :href="link.link != 'subscription' ? route(link.link) : '/billing'"
      class="border-b-2 text-xl text-theme-green hover:text-hover-theme-green/90 hover:border-hover-theme-green/90 flex items-center py-2.5">
      <div class="flex justify-start relative w-full h-[70px] p-4">
        <div class="flex items-center justify-center">
          <component :is="link.icon" class="w-6 h-6" />
        </div>
        <div class="flex flex-col ml-4 justify-center">
          <span>{{ link.label }}</span>
          <p v-if="link.description" class="text-base">
            {{ link.description }}
          </p>
        </div>
        <div class="flex items-center absolute right-4">
          <component :is="link.leftIcon" class="w-6 h-6" />
        </div>
      </div>
    </Link>
    <Link
      :href="route('setting.logout')"
      method="post"
      as="button"
      class="text-xl text-theme-green hover:border-hover-theme-green flex items-center">
      <div class="flex justify-start relative w-full h-[70px] p-4">
        <div class="flex items-center justify-center">
          <PowerIcon class="w-6 h-6" />
        </div>
        <div class="flex flex-col ml-4 justify-center">
          <span>Logout</span>
        </div>
      </div>
    </Link>
  </div>
</template>
<script setup>
import route from 'ziggy-js'
import { Link } from '@inertiajs/vue3'
import { PowerIcon } from '@heroicons/vue/24/solid'
import { useNavigationLinks } from '../../Composables/useNavigationLinks'

const { settingNavLinks } = useNavigationLinks()


</script>
