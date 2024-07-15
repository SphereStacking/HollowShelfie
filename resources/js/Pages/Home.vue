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
  upcomingEventsUrl: {
    type: String,
    required: true
  },
  upcomingEvents: {
    type: Array,
    required: true
  },
  ongoingEventCount: {
    type: Number,
    required: true
  },
  upcomingEventCount: {
    type: Number,
    required: true
  },
  pickups: {
    type: Array,
    required: true
  }
})

const getButtonText = (event) => {
  return `${event.name} (${event.count})`
}

const modalEventShare = ref(null)

const querySetter = (value, type) => {
  return [
    { include: 'and', type: type, value: value.name },
  ]
}
const eventItems = ref([])
eventItems.value.push({ url: props.ongoingEventsUrl, events: props.ongoingEvents, title: 'open', icon: 'eventOpen' })
eventItems.value.push({ url: props.upcomingEventsUrl, events: props.upcomingEvents, title: 'upcoming', icon: 'eventUpcoming' })
eventItems.value.push({ url: props.newEventsUrl, events: props.newEvents, title: 'New', icon: 'new' })

const pickupItems = props.pickups
</script>

<template>
  <AppLayout title="Dashboard">
    <ModalEventShareConfirm ref="modalEventShare" mode="participant" />
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        Home
      </h2>
    </template>
    <div class="mx-auto mt-5 grid max-w-7xl grid-cols-12 gap-3 md:gap-6 ">
      <WidgetOngoingEventCount class="col-span-12 md:col-span-4" />
      <WidgetPlanningEventCount class="col-span-12 md:col-span-4" />

      <AreaAdvertisementRecruitment as="a" link="https://sainakey.booth.pm/items/4876171" class=" col-span-12  shadow-xl shadow-base-200 md:col-span-4">
        <img src="storage/images/Advertisement/01_SynapseRack_VJ_Tool.png" alt="SynapseRack VJ Tool" class=" max-h-40">
      </AreaAdvertisementRecruitment>

      <div v-if="pickupItems.data.length > 0" class="col-span-12 flex flex-col gap-2 ">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold">
          <IconTypeMapper type="pickup" class="shrink-0 text-4xl" />
          Pickup Eventer
        </div>
        <div class="flex flex-wrap gap-2 ">
          <Link v-for="(pickup) in pickupItems.data" :key="pickup.id" :href="pickup.profile_url">
            <HoverEventerBadge :performer="pickup" is-hover-hideing-animation />
          </Link>
        </div>
      </div>

      <div class="col-span-12 flex flex-col gap-2 md:col-span-6">
        <div class="divider divider-start  mt-5 w-full text-3xl font-bold">
          <IconTypeMapper type="category" class="shrink-0 text-4xl" />
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
          <IconTypeMapper type="tag" class="shrink-0 text-4xl" />
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
          <IconTypeMapper :type="items.icon" class="shrink-0 text-4xl" />
          <h3 class="font-bold">
            {{ $t(items.title) }}
          </h3>
        </div>
        <template v-if="items.events.length == 0">
          <div class="flex flex-col items-center justify-center ">
            <div class="flex w-96 flex-col items-center justify-center gap-2 rounded-md bg-base-200 p-4">
              <p class="text-md text-center font-black tracking-widest text-info">
                <span class="text-lg">{{ $t(items.title) }}</span>の<span class="text-2xl font-black text-accent">イベント</span>は<span class="text-lg">ありません！</span><br>
              </p>
              <Link class="btn btn-neutral" :href="route('event.create')">
                イベントを掲載する！
                <IconTypeMapper type="arrowRight" class="shrink-0 text-2xl" />
              </Link>
            </div>
          </div>
        </template>
        <template v-else>
          <CarouselEventHero :events="items.events" />
          <div class="my-2 grid w-full grid-cols-2 gap-2 sm:grid-cols-2 md:grid-cols-4  md:gap-6 xl:grid-cols-5">
            <CardEvent
              v-for="(event, index) in items.events"
              :key="index" :event="event" class="my-2"
              @share="modalEventShare.onBtnOpenModal(event)" />
          </div>
          <Link class=" btn btn-neutral mx-auto my-10 w-40" :href="items.url">
            show more!
            <IconTypeMapper type="arrowRight" class="size-8 shrink-0" />
          </Link>
          <div class="col-span-12">
            <AreaAdvertisementRecruitment class="size-full h-24" />
          </div>
        </template>
      </div>
      <div class="col-span-12 flex flex-col items-center justify-center py-20">
        <div class="flex w-96 flex-col items-center justify-center gap-2 rounded-md bg-base-200 p-4">
          <p class="text-md text-center font-black tracking-widest text-info">
            <span class="text-lg">あなた</span>の<span class="text-2xl font-black text-accent">イベント</span>を<span class="text-2xl font-black text-accent">掲載</span>して<br>
            <span class="text-2xl font-black text-accent">告知</span>してみませんか？
          </p>
          <Link class="btn btn-neutral" :href="route('event.create')">
            イベントを掲載する！
            <IconTypeMapper type="arrowRight" class="size-8 shrink-0" />
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
