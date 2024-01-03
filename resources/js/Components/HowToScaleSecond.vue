<template>
  <div>
    <p>Evaluate how well the affirmation aligns with you:</p>
    <div class="l:grid grid-cols-2 gap-2 star-container sm:grid-cols-1 md:rid-cols-1">
      <div class="flex  px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Very little</p>
      </div>
      <div class="flex  px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Little</p>
      </div>
      <div class="flex  px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Good</p>
      </div>
      <div class="flex  px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Very good</p>
      </div>
      <div class="flex  px-2 mb-2">
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <img src="images/svg/star.svg" alt="star-svg" class="star-icon" />
        <p>Great</p>
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
.star-container .flex p{
  margin-left: 20px;
}
</style>