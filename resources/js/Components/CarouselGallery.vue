<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from 'vue3-carousel'
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
</script >

<template>
  <Card>
    <Carousel :items-to-show="1" :wrap-around="false" v-model="currentSlide">
      <Slide v-for="slide in props.images" :key="slide">
        <img :src="slide" alt="image" class="carousel__item" />
      </Slide>
    </Carousel>

    <Carousel :items-to-show="4" :wrap-around="true" v-model="currentSlide" ref="carousel">
      <Slide v-for="(slide, index) in props.images" :key="index">
        <img :src="slide" alt="image" class="carousel__item" @click="slideTo(index - 1)" />
      </Slide>
    </Carousel>
  </Card>
</template>

