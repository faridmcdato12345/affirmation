<template>
  <div class="emoji-container">
    <picture>
      <source srcset="https://fonts.gstatic.com/s/e/notoemoji/latest/1f609/512.webp" type="image/webp" />
      <img src="https://fonts.gstatic.com/s/e/notoemoji/latest/1f609/512.gif" alt="😉" width="100" height="100" />
    </picture>
    <div>
      <img class="thumbs-up" src="images/thumbs-up.png" alt="" srcset="" />
    </div>
  </div>
</template>

<script setup>

</script>

<style scoped>
picture{
    display:flex;
    justify-content: center;
    align-items: center;
}
.emoji-contaier {
    position: relative;
}

.thumbs-up {
    visibility: hidden;
    position: absolute;
    left: 61%;
    transform: translateX(-50%) scale(1.5) skewX(-10deg);
    animation: tumbsup 2s ease-in-out infinite;
}

@keyframes tumbsup {
    0% {
        visibility: hidden;
        width: 0px;
        height: 0px;
        top: 35%;
    }

    100% {
        visibility: visible;
        top: 25%;
        width: 20px;
        height: 30px;
    }
}
</style>