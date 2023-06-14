<template>
  <div class="row">
    <div class="col-lg-8 left-container flex justify-center items-center">
      <div class="typewriter text-center w-full">
        <h1 class="text-white italic ">
          “Attitude is a choice. Happiness is a choice. Optimism is a choice. Kindness is a choice. Giving is a choice. Respect is a choice. Whatever choice you make makes you. Choose wisely.”
        </h1>
        <h2 class="text-white italic ">
          ― Roy T. Bennett, The Light in the Heart
        </h2>
      </div>
    </div>
    <div class="col-lg-4">
      <slot />
    </div>
  </div>
</template>
<script>
export default {

}
</script>
<style scoped>
.left-container{
    background-image: url('../../../../images/milky-way-ge3b943f98_1280.jpg');
    background-repeat: no-repeat;
    background-size: cover;
}
</style>