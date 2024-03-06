<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

import { router } from '@inertiajs/vue3'

const props = defineProps({
  events: {
    type: Array,
    default: () => [],
    required: true
  },
})

const currentSlide = ref()

const next = () => {
  if (currentSlide.value < props.events.length - 1) {
    currentSlide.value++
  } else {
    currentSlide.value = 0
  }
}

const prev = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--
  } else {
    currentSlide.value = props.events.length - 1
  }
}

const getEventShow = (event) => {
  router.visit(route('event.show', event.id), {
    method: 'get',
    preserveState: false,
    preserveScroll: true,
    onSuccess: (result) => {
      console.log(result)
    }
  })
}
</script>

<template>
  <div class="group relative w-full">
    <button
      class="absolute -left-10  top-1/2 z-10 -translate-y-1/2  rounded-md opacity-0 transition-all duration-200   hover:bg-accent hover:text-accent-content  group-hover:left-0 group-hover:opacity-100"
      @click="prev">
      <Icon icon="mdi:chevron-left" class="text-4xl" />
    </button>
    <button
      class=" absolute -right-10 top-1/2  z-10 -translate-y-1/2 rounded-md opacity-0 transition-all duration-200  hover:bg-accent hover:text-accent-content  group-hover:right-0 group-hover:opacity-100"
      @click="next">
      <Icon icon="mdi:chevron-right" class="text-4xl" />
    </button>
    <Carousel
      v-model="currentSlide" :autoplay="5000" wrap-around
      class=" absolute flex flex-col" pause-autoplay-on-hover>
      <Slide v-for="(event, index) in events" :key="index">
        <div class="carousel__item hero  rounded-md bg-base-200 ">
          <div class="hero-content flex-col lg:flex-row">
            <div class=" relative aspect-a4 h-80">
              <template v-if="event.files.length>0">
                <img :src="event.files[0].public_url">
              </template>
              <template v-else>
                <div class="h-full w-full bg-base-300">
                  <Icon icon="mdi:image-off" class=" absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2  text-6xl" />
                </div>
              </template>
            </div>
            <div class="flex flex-col items-start gap-2">
              <div class="flex w-full flex-row justify-between">
                <div>{{ event.event_timeline_status }}</div>
                <div class="flex gap-1">
                  <BtnSwapEventBookmark :event-id="event.id" :check="event.auth_user?.is_bookmark" />
                  <BtnSwapEventGood
                    :event-id="event.id" :check="event.auth_user?.is_good" :count="event.short_good_count"
                    show-count />
                </div>
              </div>

              <h1 class="text-5xl font-bold">
                {{ event.title }}
              </h1>
              <div class=" mx-auto flex w-full flex-row gap-1 lg:col-span-7 lg:col-start-1 lg:row-start-2">
                <!-- category -->
                <div class="flex items-center gap-1 ">
                  <IconTypeMapper type="category" class="text-xl" />
                  <BtnEventSerchItem :value="event.category_name" type="category" is-navigate />
                </div>
                <!-- tag -->
                <div class="flex flex-row items-center gap-1">
                  <div class="mr-auto flex items-center gap-1  rounded-md">
                    <IconTypeMapper type="tag" class="text-xl" />
                    <template v-for="(tag, index) in event.tags" :key="index">
                      <BtnEventSerchItem :value="tag" type="tag" is-navigate />
                    </template>
                  </div>
                </div>
              </div>
              <!-- organizers -->
              <div class="flex w-full flex-col justify-center">
                <div class="flex flex-row items-center gap-1">
                  <Icon icon="mdi:food" class="text-md" />
                  <div>organizers</div>
                </div>
                <div class="flex flex-wrap  gap-1 rounded-xl  bg-base-200 p-2">
                  <a
                    v-for="(organizer, index ) in event.organizers" :key="index" :href="organizer.profile_url"
                    class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1"
                    :data-tip="organizer.name">
                    <img :src="organizer.imag_url">
                  </a>
                </div>
              </div>
              <!-- performers -->
              <div class="flex flex-col justify-center ">
                <div class="flex flex-row items-center gap-1">
                  <Icon icon="mdi:food" class="text-md" />
                  <div>performers</div>
                </div>
                <div class="flex w-full flex-wrap gap-1 rounded-xl bg-base-200 p-2">
                  <a
                    v-for="(performer, index ) in event.performers" :key="index" :href="performer.profile_url"
                    class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1"
                    :data-tip="performer.name">
                    <img :src="performer.image_url">
                  </a>
                </div>
              </div>
              <!-- <p class="py-6">{{ event.description }}</p> -->
              <button class=" btn btn-primary btn-sm w-full" @click="getEventShow(event)">
                show more!
              </button>
            </div>
          </div>
        </div>
      </Slide>
      <template #addons>
        <Pagination />
      </template>
    </Carousel>
  </div>
</template>

