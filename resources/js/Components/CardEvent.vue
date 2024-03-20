
<script setup>
import { Link } from '@inertiajs/vue3'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

defineProps({
  event: {
    type: Object,
    required: true
  },
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
    <div class="relative aspect-a4 min-w-40">
      <template v-if="event.files.length>0">
        <Carousel
          :autoplay="5000" wrap-around class=""
          pause-autoplay-on-hover>
          <Slide v-for="(image, index) in event.files" :key="index">
            <img class="carousel__item h-full w-full object-cover" :src="image.public_url">
          </Slide>
        </Carousel>
      </template>
      <template v-else>
        <div class="h-full w-full bg-base-300">
          <Icon icon="mdi:image-off" class=" absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2  text-6xl" />
        </div>
      </template>
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
