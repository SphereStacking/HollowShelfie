
<script setup>
import { Link, router } from '@inertiajs/vue3'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})

import file3 from './LXIX_Design_196-4.png'
import file1 from './LXIX_Design_224-4.png'
import file2 from './LXIX_Design_225-5.png'

const image_flyers = [
  file1,
  file2,
  file3,
]

const randomColor = computed(() => {
  const colors = ['blue', 'green', 'red', 'yellow', 'indigo', 'purple', 'pink']
  return colors[Math.floor(Math.random() * colors.length)]
})
</script>

<template>
  <div
    class=" card card-compact border border-transparent bg-base-200 shadow-xl shadow-blue-500/50 transition-all duration-200 hover:-translate-y-1 hover:border-base-300 hover:bg-base-100 hover:shadow-green-300/50  ">
    <div class="mx-2 mt-2 flex justify-between">
      <div class="badge badge-primary">
        {{ event.category_name }}
      </div>
      <div class="truncate whitespace-nowrap text-xs  font-bold">
        {{ event.event_timeline_status }}
      </div>
    </div>

    <div class="mx-3 mt-1 truncate whitespace-nowrap font-bold ">
      {{ event.title }}
    </div>
    <div class="relative">
      <Carousel
        :autoplay="5000" wrap-around class=" absolute flex flex-col"
        pause-autoplay-on-hover>
        <Slide v-for="(image, index) in image_flyers" :key="index">
          <img class="carousel__item" :src="image">
        </Slide>
      </Carousel>
    </div>
    <div class="m-2 flex justify-between">
      <div class="flex gap-1">
        <BtnSwapEventBookmark :event-id="event.id" :check="event.auth_user?.is_bookmark" />
        <BtnSwapEventGood
          :event-id="event.id" :check="event.auth_user?.is_good" :count="event.short_good_count"
          show-count />
      </div>
      <div></div>
      <Link :href="route('event.show', event.id)" class="text-md btn btn-link btn-active btn-xs m-0 p-0">
        Read More
      </Link>
      <div></div>
    </div>
  </div>
</template>

<style lang="">

</style>
