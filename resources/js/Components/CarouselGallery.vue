<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
  images: {
    type: Array,
    default: () => [],
    required: true
  },
})

const currentSlide = ref()
const slideTo = (val) => {
  currentSlide.value = val
}
const next = () => {
  if (currentSlide.value < props.images.length - 1) {
    currentSlide.value++
  } else {
    currentSlide.value = 0
  }
}

const prev = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--
  } else {
    currentSlide.value = props.images.length - 1
  }
}
</script>

<template>
  <div class="flex h-full flex-col justify-between gap-2">
    <slot name="header"></slot>

    <div class="aspect-w-16 aspect-h-9 relative min-h-80 " :class="[!props.images.length ? 'rounded-xl bg-base-300' : '']">
      <template v-if="props.images.length>0">
        <Carousel
          v-model="currentSlide" :items-to-show="1" :wrap-around="true">
          <Slide v-for="(image, index) in props.images" :key="index">
            <img class="carousel__item" :src="image">
          </Slide>
        </Carousel>
      </template>
      <template v-else>
        <div class="h-full w-full bg-base-300">
          <Icon icon="mdi:image-off" class=" absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2  text-6xl" />
        </div>
      </template>
    </div>

    <div class=" flex flex-row items-center justify-between gap-1">
      <button class="btn btn-square  btn-md" @click="next">
        <Icon icon="mdi:chevron-left" class="text-4xl" />
      </button>
      <Carousel
        ref="carousel" v-model="currentSlide" :items-to-show="4"
        :wrap-around="false">
        <Slide v-for="(slide, index) in props.images" :key="index" class="rounded-sm px-0.5">
          <img
            :src="slide" alt="image" class="carousel__item"
            @click="slideTo(index)">
        </Slide>
      </Carousel>
      <button class="btn btn-square  btn-md" @click="prev">
        <Icon icon="mdi:chevron-right" class="text-4xl" />
      </button>
    </div>
    <slot name="footer"></slot>
  </div>
</template>

