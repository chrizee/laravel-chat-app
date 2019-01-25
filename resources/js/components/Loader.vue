<template>
    <div class="lds-hourglass" v-show="display"></div>
</template>

<script>
    export default {
        props: {
          display: {
            type: Boolean,
            required: true,
            default: false
          }
        }
    }
</script>

<style scoped>
.lds-hourglass {
  display: inline-block;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-left: -32px;
  margin-top: -32px;
  width: 64px;
  height: 64px;
  z-index: 999;
}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  box-sizing: border-box;
  border: 26px solid;
  border-color: #f58634 transparent #d2d6de transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}


</style>