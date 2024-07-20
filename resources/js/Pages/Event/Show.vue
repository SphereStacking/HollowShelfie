<script setup>
import { GetEventDetailMetaTags } from '@/Modules/MetaTag/metaTagHelpers'
import { _eventPeriod } from '@/Utils/domain/event'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  event: {
    type: String,
    required: true
  },
  trendTags: {
    type: Array,
    default: () => []
  },
  config: {
    type: Object,
    default: () => {}
  }
})
defineEmits(
  ['click']
)
const modalEventShare = ref(null)
const supportings = props.config.supportings ?? []

const eventPeriod = computed(() => {
  return _eventPeriod(props.event.start_date, props.event.end_date)
})

const hasCategory = computed(() => {
  return props.event.category_names.length > 0
})
const hasTag = computed(() => {
  return props.event.tags.length > 0
})

const metaTags = GetEventDetailMetaTags()

const calendarLinks = computed(() => {
  return [{ label: '[👻HollowShelfie] ' + props.event.title, url: usePage().props.ziggy.location }]
})
const calendarLocation = computed(() => {
  return props.event.instances[0]?.instance_type ?? ''
})
const calendarDates = computed(() => {
  return props.event.start_date && props.event.end_date ? [props.event.start_date, props.event.end_date] : []
})
</script>
<template>
  <AppLayout title="Event Detail" :meta-tags="metaTags">
    <ModalEventShareConfirm ref="modalEventShare" />
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        Event Detail
      </h2>
    </template>
    <div class="mx-auto grid max-w-7xl auto-rows-min gap-2 pt-4 lg:grid-cols-12 lg:gap-4">
      <!-- header -->
      <div class="flex flex-col items-center gap-1 md:items-start lg:col-start-1 lg:col-end-10">
        <div class="flex w-full flex-col justify-between gap-2 md:flex-row ">
          <div class="flex flex-col items-center gap-2 md:flex-row">
            <BadgeEventStatus
              class="badge-md" :status="event.status"
              :label="$t(event.status)" />
            <p class="text-wrap break-all font-mono text-lg italic md:text-xl">
              {{ eventPeriod }}
            </p>
          </div>

          <div class="flex items-center justify-center gap-2">
            <BtnSwapEventBookmark :event-id="event.alias" :check="event.auth_user?.is_bookmark" />
            <BtnSwapEventGood
              :event-id="event.alias" :check="event.auth_user?.is_good" :count="event.short_good_count"
              show-count />
            <DropdownCalendarEvent
              :title="event.title" :dates="calendarDates" :description="event.description"
              :location="calendarLocation" :links="calendarLinks" />
            <button class="btn btn-xs px-1" @click="modalEventShare.onBtnOpenModal(event)">
              <IconTypeMapper type="share" class="text-xl" />
            </button>
          </div>
        </div>
        <h1 class="my-4 break-all text-4xl font-bold md:my-0 md:text-5xl lg:text-6xl">
          {{ event.title }}
        </h1>
      </div>

      <div class="flex w-full flex-col flex-wrap gap-1 md:flex-row lg:col-span-9 lg:col-start-1 lg:row-start-2">
        <div v-if="hasCategory" class="flex  flex-row  items-center gap-1">
          <IconTypeMapper type="category" class="size-5" />
          <div class="flex flex-wrap gap-1">
            <template v-for="(category_name, index) in event.category_names" :key="index">
              <BtnEventSearchItem
                :value="category_name" type="category" class=""
                is-navigate />
            </template>
          </div>
        </div>
        <div v-if="hasTag" class="flex flex-row items-center gap-1">
          <IconTypeMapper type="tag" class="size-5" />
          <div class="flex flex-wrap gap-1">
            <template v-for="(tag, index) in event.tags" :key="index">
              <BtnEventSearchItem :value="tag" type="tag" is-navigate />
            </template>
          </div>
        </div>
      </div>
      <!-- header -->
      <!-- leftside -->
      <div class=" lg:col-span-3 lg:row-start-3">
        <div class="sticky top-24 w-full rounded-md bg-base-300 p-4">
          <CarouselGallery :images="event.files.map(file => file.public_url)" zoomble />
          <div class="divider mb-0"></div>
          <ShowInstances :instances="event.instances" />
          <ShowOrganizers :organizers="event.organizers" />
          <ShowPerformers :performers="event.performers" />
        </div>
      </div>
      <!-- leftside -->
      <!-- Main -->
      <div class="mx-auto flex w-full flex-col gap-2 lg:col-span-6">
        <ShowDescription :description="event.description" />

        <ShowTimetable :time-table="event.time_table" />
      </div>
      <!-- Main -->
      <!-- RightSide -->
      <div class="lg:col-start-10 lg:col-end-13 lg:row-span-2 lg:row-start-1 ">
        <AreaAdvertisementRecruitment class="aspect-[4/3] size-full" />
      </div>
      <div class="mx-auto w-full  lg:col-start-10 lg:col-end-13  lg:row-span-3 lg:row-start-3">
        <aside class="sticky top-12" aria-labelledby="sidebar-right">
          <div class="sticky top-36 flex  flex-col gap-4">
            <!-- 人気のタグ -->
            <Card class="w-full">
              <template #title>
                <h4 class="font-bold uppercase ">
                  人気のタグ
                </h4>
              </template>
              <div class="flex flex-wrap items-center gap-1">
                <template v-for="(tag, index) in trendTags" :key="index">
                  <BtnEventSearchItem :value="tag" type="tag" is-navigate />
                </template>
              </div>
            </Card>
            <AreaAdvertisementRecruitment class="aspect-[4/3] size-full" />
            <AreaAdvertisementRecruitment class="aspect-[4/3] size-full" />
            <AreaAdvertisementRecruitment class="aspect-[4/3] size-full" />
            <!-- コミュニティスポンサー -->
            <Card class="w-full">
              <template #title>
                <div class="flex w-full flex-row justify-between gap-2">
                  <AppName />を支援する!
                </div>
              </template>
              <ul class="list-none">
                <li>
                  <h4 class="font-bold uppercase">
                    継続支援
                  </h4>
                </li>
                <li>
                  <a class="ml-2 text-3xl font-black text-base-content hover:text-accent" :href="supportings.fanbox">Fanbox</a>
                </li>
                <li>
                  <a class="ml-2 text-3xl font-black text-base-content hover:text-accent" :href="supportings.patreon">Patreon</a>
                </li>
                <li>
                  <h4 class="font-bold uppercase">
                    単発支援
                  </h4>
                </li>
                <li>
                  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="LEZH4L3FZK4ZU">
                    <input type="hidden" name="currency_code" value="JPY">
                    <button type="submit" class="ml-2 text-3xl font-black text-base-content hover:text-accent">
                      PayPal
                    </button>
                  </form>
                </li>
              </ul>
            </Card>
          </div>
        </aside>
      </div>
      <!-- RightSide -->
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
