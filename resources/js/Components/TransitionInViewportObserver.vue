<script setup>
import { ref, onMounted, watch, defineProps } from 'vue'

const isVisible = ref(false)
const containerRef = ref(null)

const props = defineProps({
  // IntersectionObserverのオプション用のprops
  observerOptions: {
    type: Object,
    default: () => ({
      root: null,
      rootMargin: '-20px 0px -20px 0px',
      threshold: 0.5
    })
  }
})

onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      isVisible.value = entry.isIntersecting
    })
  }, props.observerOptions)

  watch([containerRef], ([newContainerRef]) => {
    if (newContainerRef) observer.observe(newContainerRef)
  }, { immediate: true })
})
watch(isVisible, async (newVal) => {
  if (newVal) {
    await nextTick()
    let contentHeight = 0
    for (const child of containerRef.value.children) {
      contentHeight += child.offsetHeight
    }
    containerRef.value.style.height = `${contentHeight}px`
  }
})
</script>

<template>
  <div ref="containerRef">
    <span></span>
    <transition v-bind="$attrs">
      <slot v-if="isVisible"></slot>
    </transition>
  </div>
</template>
