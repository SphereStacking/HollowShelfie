<script setup>
import { decomposeDate, getDurationBetweenDates } from '@/Utils/Date'
import { GetEventDetailMetaTags } from '@/Modules/MetaTag/metaTagHelpers'

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

const supportings = props.config.supportings ?? []

const formattedStartDate = computed(() => {
  if (!props.event.start_date) {
    return { weekday: '', hour: '', minute: '', second: '' }
  }
  return decomposeDate(props.event.start_date)
})
const eventPeriod = computed(() => {
  if (!props.event.start_date || !props.event.end_date) {
    return '日時が入力されていません'
  }
  let durationString = ''
  const duration = getDurationBetweenDates(props.event.start_date, props.event.end_date)
  // duration オブジェクトのキーをチェックして、存在するものだけ文字列に追加
  if (duration.hours) durationString += duration.hours + 'h '
  if (duration.minutes) durationString += duration.minutes + 'm '
  if (duration.seconds) durationString += duration.seconds + 's '

  // 末尾の空白を削除し、必要に応じて ' - ' を追加
  durationString = durationString.trim()
  if (durationString) {
    durationString = ' - ' + durationString
  }
  return `[${formattedStartDate.value.weekday}] ${formattedStartDate.value.hour}:${formattedStartDate.value.minute}:${formattedStartDate.value.second} ${durationString}`
})

const hasCategory = computed(() => {
  return props.event.category_names.length > 0
})
const hasTag = computed(() => {
  return props.event.tags.length > 0
})

const snsShare = {
  title: props.event.title,
  period: eventPeriod.value,
  route: route('event.show', props.event.alias),
  instances: props.event.instances.map((instance) => instance.display_name),
  organizers: props.event.organizers.map((organizer) => organizer.name),
  performers: props.event.performers.map((performer) => performer.name),
  categoryNames: props.event.category_names,
  tags: props.event.tags.map((tag) => '#'+tag),
}

const metaTags = GetEventDetailMetaTags()

</script>
<template>
  <AppLayout title="Event Detail" :meta-tags="metaTags">
    <!-- <MetaTagEventDetail /> -->
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        Event Detail
      </h2>
    </template>
    <div class="mx-auto grid max-w-7xl auto-rows-min gap-2 pt-4 lg:grid-cols-12 lg:gap-4">
      <!-- header -->
      <div class="lg:col-start-1 lg:col-end-10">
        <div class="flex flex-row items-center ">
          <div class="flex grow flex-col ">
            <div class="flex flex-row items-center justify-between">
              <div class="flex flex-row items-center gap-2">
                {{ formattedStartDate.year }}/{{ formattedStartDate.month }}/{{ formattedStartDate.day }}   {{ eventPeriod }}
                <BadgeEventStatus
                  class="lg:col-start-1 lg:row-start-2" :status="event.status"
                  :label="$t(event.status)" />
              </div>
              <div class="flex items-center gap-2 rounded-md p-1">
                <BtnSwapEventBookmark :event-id="event.alias" :check="event.auth_user?.is_bookmark" />
                <BtnSwapEventGood
                  :event-id="event.alias" :check="event.auth_user?.is_good" :count="event.short_good_count"
                  show-count />
                <BtnSnsShareEventToX
                  :title="snsShare.title" :period="snsShare.period" :instance-names="snsShare.instances"
                  :organizer-names="snsShare.organizers" :performer-names="snsShare.performers"
                  :category-names="snsShare.categoryNames" :tags="snsShare.tags" :url="snsShare.route" />
              </div>
            </div>
            <div class=" prose lg:prose-xl ">
              <h1> {{ event.title }}</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="mx-auto flex w-full flex-col gap-1 md:flex-row lg:col-span-7 lg:col-start-1 lg:row-start-2">
        <div v-if="hasCategory" class="flex flex-row items-center gap-1">
          <div class="mr-auto flex items-center gap-1  rounded-md">
            <IconTypeMapper type="category" class="text-xl" />
            <template v-for="(category_name, index) in event.category_names" :key="index">
              <BtnEventSearchItem :value="category_name" type="category" is-navigate />
            </template>
          </div>
        </div>
        <div v-if="hasTag" class="flex flex-row items-center gap-1">
          <div class="mr-auto flex items-center gap-1  rounded-md">
            <IconTypeMapper type="tag" class="text-xl" />
            <template v-for="(tag, index) in event.tags" :key="index">
              <BtnEventSearchItem :value="tag" type="tag" is-navigate />
            </template>
          </div>
        </div>
      </div>
      <!-- header -->
      <!-- leftside -->
      <div class="lg:col-span-3 lg:row-start-3">
        <div class="sticky top-24 rounded-md bg-base-300 p-4">
          <CarouselGallery :images="event.files.map(file => file.public_url)" />
        </div>
      </div>
      <!-- leftside -->
      <!-- Main -->
      <div class="mx-auto flex w-full flex-col gap-2 lg:col-span-6">
        <ShowDescription :description="event.description" />
        <ShowOrganizers :organizers="event.organizers" />
        <ShowPerformers :performers="event.performers" />
        <ShowInstances :instances="event.instances" />
        <ShowTimetable :time-table="event.time_table" />
      </div>
      <!-- Main -->
      <!-- RightSide -->
      <div class="lg:col-start-10 lg:col-end-13 lg:row-span-2 lg:row-start-1 ">
        <AreaAdvertisementRecruitment class="size-full" />
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
            <AreaAdvertisementRecruitment class="h-32 w-full" />
            <AreaAdvertisementRecruitment class="h-32 w-full" />
            <AreaAdvertisementRecruitment class="h-32 w-full" />
            <!-- コミュニティスポンサー -->
            <Card class="w-full">
              <template #title>
                <div class="flex w-full flex-row justify-between gap-2">
                  <AppName />を支援する!
                </div>
              </template>
              <ul class="list-none">
                <li>
                  <a class="text-3xl font-black text-base-content hover:text-accent" :href="supportings.fanbox">fanbox </a>
                </li>
                <li>
                  <a class="text-3xl font-black text-base-content hover:text-accent" :href="supportings.patreon">patreon </a>
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
