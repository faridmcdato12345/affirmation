<template>
  <div>
    <p>1. Internalize and evaluate how you feel today.</p>
    <p>2. Rate what you feel today by clicking the stars.</p>
    <div class="l:grid grid-cols-2 gap-2 star-container sm:grid-cols-1 md:rid-cols-1">
      <div class="flex px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>&nbsp;Very sad</p>
      </div>
      <div class="flex px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Sad</p>
      </div>
      <div class="flex px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Slightly Happy</p>
      </div>
      <div class="flex px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Happy</p>
      </div>
      <div class="flex px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Delighted</p>
      </div>
    </div>
  </div>
</template>

<script setup>


</script>

<style scoped>
.star-icon{
  width: 30px;
  height: 30px;
}
p{
  color:#fff;
  
}
.star-container .flex p {
  margin-left: 20px;
}
</style>