<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'
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
</script >

<template>
  <Card>
    <slot name="header"></slot>
    <Carousel :items-to-show="1" :wrap-around="true" v-model="currentSlide" class="rounded-sm">
      <Slide v-for="(slide, index) in props.images" :key="index">
        <img :src="slide" alt="image" class="carousel__item " />
      </Slide>
    </Carousel>

    <div class=" flex flex-row items-center gap-1">
      <button class="btn p-0" @click="next">
        <Icon icon="mdi:chevron-left" class="text-4xl"></Icon>
      </button>
      <Carousel :items-to-show="4" :wrap-around="false" v-model="currentSlide" ref="carousel">
        <Slide v-for="(slide, index) in props.images" :key="index" class="px-0.5 rounded-sm">
          <img :src="slide" alt="image" class="carousel__item" @click="slideTo(index)" />
        </Slide>
      </Carousel>
      <button class="btn p-0" @click="prev">
        <Icon icon="mdi:chevron-right" class="text-4xl"></Icon>
      </button>
    </div>


    <slot name="footer"></slot>
  </Card>
</template>

