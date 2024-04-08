
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
  <div class=" flex flex-col justify-end border border-transparent">
    <div class="relative  min-w-40 bg-base-300">
      <template v-if="event.files.length>0">
        <Carousel
          :autoplay="5000" wrap-around class=""
          pause-autoplay-on-hover>
          <Slide v-for="(image, index) in event.files" :key="index" class="aspect-a4">
            <img class="carousel__item " :src="image.public_url">
          </Slide>
        </Carousel>
      </template>
      <template v-else>
        <div class="h-full w-full bg-base-300">
          <Icon icon="mdi:image-off" class=" absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-6xl" />
        </div>
      </template>
    </div>

    <div class="flex flex-row justify-between">
      <Link :href="route('event.show', event.alias)" class="mx-2 truncate whitespace-nowrap font-bold ">
        {{ event.title }}
      </Link>

      <div class="dropdown dropdown-end dropdown-top">
        <div tabindex="0" role="button" class="btn btn-ghost btn-xs p-0">
          <Icon icon="mdi:dots-vertical" class="text-xl" />
        </div>
        <ul tabindex="0" class="menu dropdown-content z-[1] w-28 rounded-box bg-base-200 p-2 shadow">
          <li>
            <div>
              <BtnSwapEventBookmark :event-id="event.alias" :check="event.auth_user?.is_bookmark" />
            </div>
          </li>
          <li>
            <div>
              <BtnSwapEventGood
                :event-id="event.alias" :check="event.auth_user?.is_good" :count="event.short_good_count"
                show-count />
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="mx-2 flex justify-between">
      <div>
        {{ event.category_name }}
      </div>
      <div class="truncate whitespace-nowrap text-xs font-bold">
        {{ event.event_timeline_status }}
      </div>
    </div>
  </div>
</template>

<style lang="">

</style>
