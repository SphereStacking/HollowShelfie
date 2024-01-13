<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'
import { Link, router } from '@inertiajs/vue3'
import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
  slides: {
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
const imageClick = (url) => {
  console.log('click')
  router.visit(url, {}, {}
  )
}
</script>

<template>
  <Carousel
    v-model="currentSlide" :items-to-show="4" :wrap-around="true"
    :transition="500" class="rounded-sm">
    <Slide v-for="(slide, index) in props.slides" :key="index">
      <!-- <Link :herf="slide.url"> -->
      <div class="mx-0.5">
        <img
          :src="slide.image" alt="image" class="carousel__item "
          @click="imageClick(slide.url)">
      </div>
    </Slide>
  </Carousel>
</template>

