
<script setup>
import { ref, watch } from 'vue'

const isAnimating = ref(false)

watch(isAnimating, () => {
  setTimeout(() => {
    isAnimating.value = false
  }, 1000)
})

const animationStart = () => {
  isAnimating.value = true
}

defineExpose({
  animationStart
})
</script>

<template>
  <Transition
    enter-active-class="transition-all duration-1000"
    leave-active-class="transition-all duration-300"
    :enter-from-class="'scale-0 opacity-0'"
    leave-to-class="opacity-0">
    <ApplicationLogoSVG v-if="isAnimating" class=" absolute left-1/2 top-1/2 h-full w-full -translate-x-1/2 -translate-y-1/2" />
  </Transition>
</template>

