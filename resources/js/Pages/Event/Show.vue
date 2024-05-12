<script setup>
import { decomposeDate, getDurationBetweenDates } from '@/Utill/Date'
import { getEventPeriod } from '@/Utill/Event'
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

const formattedStartDate = decomposeDate(props.event.start_date)
const eventPeriod = computed(() => {
  let durationString = ''
  try {
    const duration = getDurationBetweenDates(props.event.start_date, props.event.end_date)
    // duration オブジェクトのキーをチェックして、存在するものだけ文字列に追加
    if (duration.hours) durationString += duration.hours + 'h '
    if (duration.minutes) durationString += duration.minutes + 'm '
    if (duration.seconds) durationString += duration.seconds + 's '
  } catch (error) {
    console.error(error)
  }
  // 末尾の空白を削除し、必要に応じて ' - ' を追加
  durationString = durationString.trim()
  if (durationString) {
    durationString = ' - ' + durationString
  }
  return `[${formattedStartDate.weekday}] ${formattedStartDate.hour}:${formattedStartDate.minute}:${formattedStartDate.second} ${durationString}`
})

const snsShare = {
  title: props.event.title,
  period: getEventPeriod(props.event.start_date, props.event.end_date),
  route: route('event.show', props.event.alias),
  instances: props.event.instances.map((instance) => instance.display_name),
  organizers: props.event.organizers.map((organizer) => organizer.name),
  performers: props.event.performers.map((performer) => performer.name),
  categoryNames: props.event.category_names,
  tags: props.event.tags.map((tag) => '#'+tag),
}
</script>
<template>
  <AppLayout title="Event Detail">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight">
        Event Detail
      </h2>
    </template>
    <div class="mx-auto grid max-w-7xl auto-rows-min gap-4 pt-4 lg:grid-cols-12 lg:gap-2">
      <!-- header -->
      <div class="lg:col-start-1 lg:col-end-10">
        <div class="flex flex-row items-center ">
          <div class="relative w-5">
            <p class="absolute w-4 grow-0 -rotate-90 text-2xl font-normal ">
              {{ formattedStartDate.year }}
            </p>
          </div>
          <div class="mr-2 flex flex-col items-center justify-center border-l-2 border-base-content pl-1">
            <div class="text-3xl font-normal">
              {{ formattedStartDate.month }}
            </div>
            <div class="text-3xl font-normal">
              {{ formattedStartDate.day }}
            </div>
          </div>
          <div class="flex grow flex-col ">
            <div class=" prose lg:prose-xl ">
              <h1> {{ event.title }}</h1>
            </div>
            <div class="flex flex-row items-center justify-between">
              <div class="flex flex-row items-center gap-2">
                <div class="text-xs font-light ">
                  {{ eventPeriod }}
                </div>
                <BadgeEventStatus
                  class="rounded-md lg:col-start-1 lg:row-start-2" :status="event.status"
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
                  :category-names="snsShare.categoryNames" :tags="snsShare.tags" :route="snsShare.route" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class=" mx-auto flex w-full flex-row gap-1 lg:col-span-7 lg:col-start-1 lg:row-start-2">
        <div class="flex flex-row items-center gap-1">
          <div class="mr-auto flex items-center gap-1  rounded-md">
            <IconTypeMapper type="category" class="text-xl" />
            <template v-for="(category_name, index) in event.category_names" :key="index">
              <BtnConditionTypeMapper type="category" class="no-animation">
                {{ category_name }}
              </BtnConditionTypeMapper>
            </template>
          </div>
        </div>
        <div class="flex flex-row items-center gap-1">
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
      <div class="mx-auto w-full lg:col-span-3 lg:row-start-3">
        <Card class="sticky top-12">
          <CarouselGallery :images="event.files.map(file => file.public_url)" />
        </Card>
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
                  支援する
                </div>
              </template>
              <div>
                <a class="text-3xl font-black text-base-content hover:text-accent" :href="supportings.fanbox">pixiv fanbox </a>
                <a class="text-3xl font-black text-base-content hover:text-accent" :href="supportings.patreon">patreon </a>
              </div>
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
