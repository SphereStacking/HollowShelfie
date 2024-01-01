<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation, Pagination } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

import file1 from '@/Components/LXIX_Design_224-4.png'
import file2 from '@/Components/LXIX_Design_225-5.png'
import file3 from '@/Components/LXIX_Design_196-4.png'
import { router } from '@inertiajs/vue3'
const image_flyers = [
  file1,
  file2,
  file3,
  file1,
  file2,
  file3,
  file1,
  file2,
  file3,
]

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
</script >

<template>
  <div class="group relative w-full">
    <button
      class="z-10 absolute  top-1/2 -left-10 opacity-0  transition-all rounded-md hover:bg-accent hover:text-accent-content   group-hover:left-0 group-hover:opacity-100  duration-200 transform -translate-y-1/2"
      @click="prev">
      <Icon icon="mdi:chevron-left" class="text-4xl"></Icon>
    </button>
    <button
      class=" z-10 absolute top-1/2  -right-10 opacity-0 transition-all rounded-md hover:bg-accent hover:text-accent-content  group-hover:right-0 group-hover:opacity-100  duration-200 transform -translate-y-1/2"
      @click="next">
      <Icon icon="mdi:chevron-right" class="text-4xl"></Icon>
    </button>
    <Carousel :autoplay="5000" wrapAround class=" absolute flex flex-col" v-model="currentSlide" pauseAutoplayOnHover>
      <Slide v-for="(event, index) in events" :key="index">
        <div class="carousel__item hero  bg-base-200 rounded-md ">
          <div class="hero-content flex-col lg:flex-row">
            <img :src="file1" class="max-w-sm shadow-2xl h-80" />
            <div class="flex flex-col gap-2 items-start">
              <div class="flex flex-row justify-between w-full">
                <div>{{ event.event_timeline_status }}</div>
                <div class="flex gap-1">
                  <BtnSwapEventBookmark :eventId="event.id" :check="event.auth_user?.is_bookmark"></BtnSwapEventBookmark>
                  <BtnSwapEventGood :eventId="event.id" :check="event.auth_user?.is_good" :count="event.short_good_count" showCount>
                  </BtnSwapEventGood>
                </div>
              </div>

              <h1 class="text-5xl font-bold">{{ event.title }}</h1>
              <div class=" flex flex-row gap-1 lg:col-span-7 w-full mx-auto lg:row-start-2 lg:col-start-1">
                <!-- category -->
                <div class="flex gap-1 items-center ">
                  <IconTypeMapper type="category" class="text-xl"></IconTypeMapper>
                  <BtnEventSerchItem :value="event.category_name" type="category" isNavigate></BtnEventSerchItem>
                </div>
                <!-- tag -->
                <div class="flex flex-row gap-1 items-center">
                  <div class="flex gap-1 rounded-md items-center  mr-auto">
                    <IconTypeMapper type="tag" class="text-xl"></IconTypeMapper>
                    <template v-for="(tag, index) in event.tags" :key="index">
                      <BtnEventSerchItem :value="tag" type="tag" isNavigate></BtnEventSerchItem>
                    </template>
                  </div>
                </div>
              </div>
              <!-- organizers -->
              <div class="flex flex-col justify-center w-full">
                <div class="flex flex-row gap-1 items-center">
                  <Icon icon="mdi:food" class="text-md"></Icon>
                  <div>organizers</div>
                </div>
                <div class="flex flex-wrap  rounded-xl bg-base-200  p-2 gap-1">
                  <a v-for="(organizer, index ) in event.organizers" :href='organizer.profile_url'
                    class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1"
                    :data-tip="organizer.name">
                    <img :src="organizer.imag_url" />
                  </a>
                </div>
              </div>
              <!-- performers -->
              <div class="flex flex-col justify-center ">
                <div class="flex flex-row gap-1 items-center">
                  <Icon icon="mdi:food" class="text-md"></Icon>
                  <div>performers</div>
                </div>
                <div class="flex flex-wrap rounded-xl bg-base-200 w-full p-2 gap-1">
                  <a v-for="(performer, index ) in event.performers" :href='performer.profile_url'
                    class="avatar tooltip h-10 transition-all duration-200 hover:-translate-y-1"
                    :data-tip="performer.name">
                    <img :src="performer.image_url" />
                  </a>
                </div>
              </div>
              <!-- <p class="py-6">{{ event.description }}</p> -->
              <button class=" btn btn-primary w-full btn-sm" @click="getEventShow(event)">show more!</button>
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

