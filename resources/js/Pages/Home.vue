<script setup>
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import { Link } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css'


import IconTypeMapper from '@/Components/IconTypeMapper.vue'

const props = defineProps({
  trendEvents: {
    type: String,
    required: true
  },
  trendCategories: {
    type: Array,
    required: true
  },
  trendTags: {
    type: Array,
    required: true
  },
  newEventsUrl: {
    type: String,
    required: true
  },
  newEvents: {
    type: Array,
    required: true
  },
  ongoingEventsUrl: {
    type: String,
    required: true
  },
  ongoingEvents: {
    type: Array,
    required: true
  },
  recentEventsUrl: {
    type: String,
    required: true
  },
  recentEvents: {
    type: Array,
    required: true
  },
  myBookmarkEvents: {
    type: Array,
    required: true
  },
})

const getButtonText = (event) => {
  return `${event.name} (${event.count})`
}
const urlSetter = (event) => {
  return event.name
}
getButtonText

const eventItems = ref([])
eventItems.value.push({ url: props.newEventsUrl, events: props.newEvents, title: 'NEW', icon: 'mdi:new-box' })
eventItems.value.push({ url: props.ongoingEventsUrl, events: props.ongoingEvents, title: 'OPEN', icon: 'mdi:door-open' })
eventItems.value.push({ url: props.recentEventsUrl, events: props.recentEvents, title: 'Recent', icon: 'mdi:timelapse' })

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        イベント
      </h2>
    </template>

    <div class="mx-auto mt-5 flex max-w-7xl flex-col gap-10">
      <CarouselEventHero :events="trendEvents"></CarouselEventHero>

      <div class="flex flex-wrap gap-2 justify-center">
        <div class="divider divider-neutral divider-start my-10 w-full text-3xl font-bold">
          <IconTypeMapper type="category"></IconTypeMapper>
          Category
        </div>
        <BtnEventSerchItem :buttonTextSetter="getButtonText" :queryValueSetter="urlSetter"
          v-for="(category) in trendCategories" :value="category" type="category" isNavigate :key="category.id">
        </BtnEventSerchItem>
      </div>
      <div class="flex flex-wrap gap-2 justify-center">
        <div class="divider divider-neutral divider-start my-10 w-full text-3xl font-bold  ">
          <IconTypeMapper type="tag"></IconTypeMapper>
          tag
        </div>

        <BtnEventSerchItem :buttonTextSetter="getButtonText" :queryValueSetter="urlSetter" v-for="(tag) in trendTags"
          :value="tag" type="tag" isNavigate :key="tag.id"></BtnEventSerchItem>
      </div>


      <div class="flex flex-col " v-for="items in eventItems">
        <div class="divider divider-neutral divider-start my-10 w-full text-3xl font-bold">
          <Icon :icon="items.icon"></Icon>
          <h4 class="font-bold">{{ items.title }}</h4>
        </div>

        <div class="w-full grid xl:grid-cols-6 md:grid-cols-4  sm:grid-cols-3 grid-cols-2  gap-10 ">
          <CardEvent v-for="(event, index) in items.events" :key="index" :event="event" class=" min-h-48 " />
        </div>
        <Link class=" btn btn-neutral w-full mt-10" :href="items.url">show more!</Link>
      </div>

    </div>
  </AppLayout>
</template>

<style lang="">

</style>
