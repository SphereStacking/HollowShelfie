<script setup>

import { Link } from '@inertiajs/vue3'

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
eventItems.value.push({ url: props.ongoingEventsUrl, events: props.ongoingEvents, title: 'OPEN', icon: 'eventOpen' })
eventItems.value.push({ url: props.recentEventsUrl, events: props.recentEvents, title: 'Recent', icon: 'eventRecent' })
eventItems.value.push({ url: props.newEventsUrl, events: props.newEvents, title: 'NEW', icon: 'new' })

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Home
      </h2>
    </template>
    <div class="mx-auto mt-5 grid max-w-7xl grid-cols-12 gap-3 md:gap-6">
      <div class="col-span-12 flex h-36 flex-wrap gap-2 rounded-lg bg-base-300 md:col-span-4">
        <div class="h-full w-full p-8">
          開催中
        </div>
      </div>
      <div class="col-span-12 flex h-36 flex-wrap gap-2 rounded-lg bg-base-300 md:col-span-4">
        <div class="h-full w-full p-8">
          開催予定
        </div>
      </div>
      <AreaAdvertisementRecruitment class="col-span-12 h-36 md:col-span-4" />

      <div class="col-span-12 flex flex-col gap-2 md:col-span-6">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold">
          <IconTypeMapper type="category" />
          Category
        </div>
        <div class="flex flex-wrap gap-2">
          <BtnEventSearchItem
            v-for="(category) in trendCategories" :key="category.id"
            :button-text-setter="getButtonText" :query-setter="querySetter" :value="category"
            type="category" is-navigate />
        </div>
      </div>

      <div class="col-span-12 flex flex-col gap-2 md:col-span-6">
        <div class="divider divider-start mt-5 w-full text-3xl font-bold  ">
          <IconTypeMapper type="tag" />
          tag
        </div>
        <div class="flex flex-wrap gap-2">
          <BtnEventSearchItem
            v-for="(tag) in trendTags" :key="tag.id" :button-text-setter="getButtonText"
            :query-setter="querySetter" :value="tag" type="tag"
            is-navigate />
        </div>
      </div>

      <div v-for="(items, index) in eventItems" :key="index" class="col-span-12 flex flex-col gap-5">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold">
          <IconTypeMapper :type="items.icon" />
          <h4 class="font-bold">
            {{ items.title }}
          </h4>
        </div>

        <CarouselEventHero :events="items.events" />

        <div class="my-2 grid w-full grid-cols-2 gap-2 sm:grid-cols-2 md:grid-cols-4  md:gap-6 xl:grid-cols-5">
          <CardEvent
            v-for="(event, index) in items.events" :key="index" :event="event"
            class="my-2" />
        </div>
        <Link class=" btn btn-neutral mx-auto my-10 w-40" :href="items.url">
          show more!
        </Link>
        <AreaAdvertisementRecruitment class="col-span-12 h-40" />
      </div>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
