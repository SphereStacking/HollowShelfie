
<script setup>
import { Link, router } from '@inertiajs/vue3';
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';

const props = defineProps({
  event: {
    type: Object,
    required: true
  },
})

import file3 from './LXIX_Design_196-4.png';
import file1 from './LXIX_Design_224-4.png';
import file2 from './LXIX_Design_225-5.png';

const image_flyers = [
  file1,
  file2,
  file3,
]


const randomColor = computed(() => {
  const colors = ['blue', 'green', 'red', 'yellow', 'indigo', 'purple', 'pink'];
  return colors[Math.floor(Math.random() * colors.length)];
});
</script>

<template>
  <div
    class=" card card-compact bg-base-200 hover:bg-base-100 border-transparent border hover:border-base-300 transition-all duration-200 hover:-translate-y-1 shadow-xl shadow-blue-500/50 hover:shadow-green-300/50  ">
    <div class="flex justify-between mt-2 mx-2">
      <div class="badge badge-primary">{{ event.category_name }}</div>
      <div class="font-bold whitespace-nowrap truncate  text-xs">
        {{ event.event_timeline_status }}
      </div>
    </div>

    <div class="font-bold mt-1 mx-3 whitespace-nowrap truncate ">
      {{ event.title }}
    </div>
    <div class="relative">
      <Carousel :autoplay="5000" wrapAround class=" absolute flex flex-col" pauseAutoplayOnHover>
        <Slide v-for="(image, index) in image_flyers" :key="index">
          <img class="carousel__item" :src="image">
        </Slide>
      </Carousel>
    </div>
    <div class="flex justify-between my-2 mx-2">
      <div class="flex gap-1">
        <BtnSwapEventBookmark :eventId="event.id" :check="event.auth_user?.is_bookmark"></BtnSwapEventBookmark>
        <BtnSwapEventGood :eventId="event.id" :check="event.auth_user?.is_good" :count="event.short_good_count" showCount>
        </BtnSwapEventGood>
      </div>
      <div></div>
      <Link :href="route('event.show', event.id)" class="btn btn-link btn-active btn-xs text-md p-0 m-0">
      Read More
      </Link>
      <div></div>
    </div>

  </div>
</template>

<style lang="">

</style>
