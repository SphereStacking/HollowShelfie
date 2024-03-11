<script setup>
import { ref, onMounted, watch } from 'vue'

const isVisible = ref(false)
const beforeRef = ref(null) // beforeRefを追加
const afterRef = ref(null) // afterRefを追加

onMounted(() => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      isVisible.value = entry.isIntersecting
    })
  }, {
    threshold: 0.1
  })

  watch([beforeRef, afterRef], ([newBeforeRef, newAfterRef]) => {
    if (newBeforeRef) observer.observe(newBeforeRef)
    if (newAfterRef) observer.observe(newAfterRef)
  }, { immediate: true })
})
</script>

<template>
  <div>
    <span ref="beforeRef"></span>
    <transition v-bind="$attrs">
      <!-- トランジションを適用するための単一のラッパー要素を追加 -->
      <slot v-if="isVisible"></slot>
    </transition>
    <span ref="afterRef"></span>
  </div>
</template>
