<template>
  <div>
    <div class="header header-fixed header-logo-center">
      <links href="/" class="header-title" />
      <links href="/" class="back-button header-icon header-icon-1">
        <i class="fas fa-arrow-left" />
      </links>
      <links href="#" data-toggle-theme class="header-icon header-icon-4">
        <i class="fas fa-lightbulb" />
      </links>
    </div>
    <slot />
    <div id="footer-bar" class="footer-bar-1">
      <links href="/">
        <i class="fa fa-home" /><span>Home</span>
      </links>
      <links href="/categories">
        <i class="fa fa-star" /><span>Categories</span>
      </links>
      <links href="/billing">
        <i class="fa fa-dollar-sign color-yellow-dark" /><span class="color-yellow-dark">Premium</span>
      </links>
      <links href="/settings">
        <i class="fa fa-cog" /><span>Settings</span>
      </links>
    </div>  
  </div>
</template>
<script>
import {Link as links
} from '@inertiajs/vue3'
export default {
  components:{
    links
  }
}
</script>