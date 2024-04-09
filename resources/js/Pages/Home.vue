<script setup>

import { Link } from '@inertiajs/vue3'
import 'vue3-carousel/dist/carousel.css'

import IconTypeMapper from '@/Components/IconTypeMapper.vue'

const props = defineProps({
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
})

const getButtonText = (event) => {
  return `${event.name} (${event.count})`
}
const querySetter = (value, type) => {
  return [
    { include: 'and', type: type, value: value.name },
  ]
}
const eventItems = ref([])
eventItems.value.push({ url: props.ongoingEventsUrl, events: props.ongoingEvents, title: 'OPEN', icon: 'mdi:door-open' })
eventItems.value.push({ url: props.recentEventsUrl, events: props.recentEvents, title: 'Recent', icon: 'mdi:timelapse' })
eventItems.value.push({ url: props.newEventsUrl, events: props.newEvents, title: 'NEW', icon: 'mdi:new-box' })

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        イベント
      </h2>
    </template>

    <div class="mx-auto mt-5 flex max-w-7xl flex-col gap-10">
      <div class="flex flex-wrap justify-center gap-2">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold">
          <IconTypeMapper type="category" />
          Category
        </div>
        <BtnEventSearchItem
          v-for="(category) in trendCategories" :key="category.id"
          :button-text-setter="getButtonText" :query-setter="querySetter" :value="category"
          type="category" is-navigate />
      </div>
      <div class="flex flex-wrap justify-center gap-2">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold  ">
          <IconTypeMapper type="tag" />
          tag
        </div>

        <BtnEventSearchItem
          v-for="(tag) in trendTags" :key="tag.id" :button-text-setter="getButtonText"
          :query-setter="querySetter" :value="tag" type="tag"
          is-navigate />
      </div>

      <div v-for="(items, index) in eventItems" :key="index" class="flex flex-col gap-5">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold">
          <Icon :icon="items.icon" />
          <h4 class="font-bold">
            {{ items.title }}
          </h4>
        </div>

        <CarouselEventHero :events="items.events" />

        <div class="my-2 grid w-full grid-cols-2 gap-2 sm:grid-cols-2  md:grid-cols-3 xl:grid-cols-4">
          <CardEvent
            v-for="(event, index) in items.events" :key="index" :event="event"
            class="my-2" />
        </div>
        <Link class=" btn btn-neutral mt-10 w-full" :href="items.url">
          show more!
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
