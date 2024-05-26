<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { router } from '@inertiajs/vue3'
import { decomposeDate } from '@/Utils/Date'
import { format } from 'date-fns'

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
  router.visit(route('event.show', event.alias), {
    method: 'get',
    preserveState: false,
    preserveScroll: true,
    onSuccess: (result) => {
      console.log(result)
    }
  })
}
const startDate = (event) => {
  return decomposeDate(event.start_date)
}

</script>

<template>
  <div class="group relative w-full">
    <button
      class="absolute -left-10  top-1/2 z-10 -translate-y-1/2  rounded-md opacity-0 transition-all duration-200   hover:bg-accent hover:text-accent-content  group-hover:left-0 group-hover:opacity-100"
      @click="prev">
      <IconTypeMapper type="arrowLeft" class="text-4xl" />
    </button>
    <button
      class=" absolute -right-10 top-1/2  z-10 -translate-y-1/2 rounded-md opacity-0 transition-all duration-200  hover:bg-accent hover:text-accent-content  group-hover:right-0 group-hover:opacity-100"
      @click="next">
      <IconTypeMapper type="arrowRight" class="text-4xl" />
    </button>
    <Carousel
      v-model="currentSlide" :autoplay="5000" wrap-around
      class=" absolute flex w-full flex-col" pause-autoplay-on-hover>
      <Slide v-for="(event, index) in events" :key="index">
        <div class="carousel__item w-full px-2">
          <div class="flex flex-col items-center justify-center gap-4 lg:flex-row">
            <CardEventImages class="w-2/6" :images="event.files" />
            <div class="flex w-4/6 flex-col items-start gap-2">
              <div class="flex w-full flex-row justify-between">
                <div> {{ format(new Date(event.start_date), 'yyyy/MM/dd HH:mm') }}</div>
                <div class="flex gap-1">
                  <BtnSwapEventBookmark :event-id="event.alias" :check="event.auth_user?.is_bookmark" />
                  <BtnSwapEventGood
                    :event-id="event.alias" :check="event.auth_user?.is_good" :count="event.short_good_count"
                    show-count />
                </div>
              </div>

              <h1 class="text-5xl font-bold">
                {{ event.title }}
              </h1>
              <!-- category -->
              <div class="flex items-center gap-1 ">
                <IconTypeMapper type="category" class="text-xl" />
                <template v-for="category in event.category_names" :key="category">
                  <BtnEventSearchItem :value="category" type="category" is-navigate />
                </template>
              </div>
              <!-- tag -->
              <div class="flex flex-row items-center gap-1">
                <div class="mr-auto flex items-center gap-1  rounded-md">
                  <IconTypeMapper type="tag" class="text-xl" />
                  <template v-for="tag in event.tags" :key="tag">
                    <BtnEventSearchItem :value="tag" type="tag" is-navigate />
                  </template>
                </div>
              </div>
              <!-- organizers -->
              <div class="flex w-full flex-col justify-center gap-1">
                <div class="flex flex-row items-center gap-1">
                  <IconTypeMapper type="organizer" class="text-md" />
                  <div>organizers</div>
                </div>
                <div class="flex flex-wrap  gap-1 rounded-xl ">
                  <AvatarLink
                    v-for="(organizer, index ) in event.organizers" :key="index" :href="organizer.profile_url"
                    :image-url="organizer.image_url" :name="organizer.name" />
                </div>
              </div>
              <!-- performers -->
              <div class="flex flex-col justify-center gap-1">
                <div class="flex flex-row items-center gap-1">
                  <IconTypeMapper type="performer" class="text-md" />
                  <div>performers</div>
                </div>
                <div class="flex w-full flex-wrap gap-1 rounded-xl ">
                  <AvatarLink
                    v-for="(performer, index ) in event.performers"
                    :key="index" size="size-16" :href="performer.profile_url"
                    :image-url="performer.image_url" :name="performer.name" />
                </div>
              </div>
              <button class=" btn btn-ghost btn-outline btn-sm w-full" @click="getEventShow(event)">
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

