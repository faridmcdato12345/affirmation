<template>
  <div class="row" style="margin-bottom: 0;">
    <div class="col-lg-8 left-container lg:flex lg:justify-center lg:items-center md:flex md:justify-center md:items-center sm:hidden hidden">
      <div class="typewriter text-center w-4/5">
        <h1 class="text-white italic ">
          "Affirmation is like a gentle breeze that whispers hope to the soul, strengthening our belief in ourselves and reminding us of the power we hold within."
        </h1>
      </div>
    </div>
    <div class="col-lg-4 col-12 col-md-4 col-sm-12">
      <Navigation routename="login" />
      <div class="lg:h-screen md:w-full md:rounded-none opacity-95 md:relative md:opacity-1  md:mt-0 sm:w-md xl:p-0 dark:border-gray-700 lg:flex lg:items-center lg:justify-center lg:flex-col">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8 w-full">
          <div class="flex justify-center items-center">
            <img src="../../../public/images/icons/256.png" width="150" height="150" alt="affirm" srcset="">
          </div>
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import Navigation from '../Components/Auth/Navigation.vue'


</script>
<style scoped>
.left-container{
    background-image: url('../../../../images/milky-way-ge3b943f98_1280.jpg');
    background-repeat: no-repeat;
    background-size: cover;
}
</style>