<template>
  <div class="">
    <slot name="header"></slot>
    <Link
      v-for="link in settingNavLinks"
      :key="`${link.label}-route`"
      :href="link.link != 'subscription' ? route(link.link) : (link.link === 'Reminder' || link.link === 'Accountability Partner') ? '#' : '/billing'"
      class="border-b text-xl dark:text-white text-theme-green hover:bg-gray-100 dark:hover:bg-gray-700/20 dark:border-gray-700 flex items-center py-1">
      <div
        :class="[
          'flex justify-start relative w-full h-[70px] p-4',
          {'justify-between': link.label === 'Reminder' || link.label === 'Accountability Partner'} 
        ]">
        <div class="flex items-center">
          <div class="flex items-center justify-center">
            <component :is="link.icon" class="w-5 h-5" />
          </div>
          <div class="flex flex-col ml-4 justify-center">
            <span class="text-base">{{ link.label }}</span>
            <p v-if="link.description" class="text-xs dark:text-gray-300">
              {{ link.description }}
            </p>
          </div>
        </div>
        <div class="flex items-center absolute right-4">
          <component :is="link.leftIcon" class="w-5 h-5" />
        </div>
      </div>
    </Link>
    <Link
      :href="route('setting.logout')"
      method="post"
      as="button"
      class="text-xl dark:text-white text-theme-green hover:border-hover-theme-green flex items-center">
      <div class="flex justify-start relative w-full h-[70px] p-4">
        <div class="flex items-center justify-center">
          <PowerIcon class="w-5 h-5" />
        </div>
        <div class="flex flex-col ml-4 justify-center">
          <span class="text-base">Logout</span>
        </div>
      </div>
    </Link>
  </div>
</template>
<script setup>
import route from 'ziggy-js'
import { Link } from '@inertiajs/vue3'
import { PowerIcon} from '@heroicons/vue/24/solid'
import { useNavigationLinks } from '../../Composables/useNavigationLinks'

const { settingNavLinks } = useNavigationLinks()


</script>
