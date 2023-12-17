<template>
  <div class="transition-all duration-200 transform" :class="{
    'opacity-100': isShow,
    'translate-y-2 opacity-0 ': !isShow,
  }
    ">
    <div v-show="isVisibleInternal">
      <slot></slot>
    </div>

  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';

const props = defineProps({
  isShow: Boolean
});

let isVisibleInternal = ref(false);

watchEffect(() => {
  isVisibleInternal.value = props.isShow;
});
</script>
