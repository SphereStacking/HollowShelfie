<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { register } from 'swiper/element/bundle'
register()

const props = defineProps({
  modelValue: {
    type: Array,
    required: true,
  },
  slideClass: {
    type: String,
    default: '',
  },
})

const swiperEl = ref(null)
const swiperApi = ref(null)

onMounted(() => {
  const swiperParams = {
    on: {
      init() { },
    },
  }
  Object.assign(swiperEl.value, swiperParams)
  swiperEl.value.initialize()
  swiperApi.value = swiperEl.value.swiper
})

watch(() => props.modelValue, () => {
  swiperApi.value.update()
  swiperApi.value.updateSlides()
})

defineExpose({
  swiperApi, swiperEl
})
</script>

<template>
  <swiper-container
    ref="swiperEl"
    init="false">
    <template v-for="(element, index) in modelValue" :key="index">
      <swiper-slide :class="slideClass">
        <slot name="item" :element="element" :index="index"></slot>
      </swiper-slide>
    </template>
  </swiper-container>
</template>

<style>
:root {
  --swiper-navigation-color: oklch(var(--a)); /* ここで色を指定します */
  --swiper-pagination-color: oklch(var(--a));
  --swiper-pagination-bullet-inactive-color: oklch(var(--a));
  --swiper-scrollbar-drag-bg-color: oklch(var(--a));
}
</style>
