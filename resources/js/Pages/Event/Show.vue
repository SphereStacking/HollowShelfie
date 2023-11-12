<script setup>
const props = defineProps({
  event: {
    type: String,
    required: true
  },

  recommendEvents: {
    type: Array,
    default: () => []
  },
  trendTags: {
    type: Array,
    default: () => []
  }
})
defineEmits(
  ['click']
)
//データ整形
const time_table = props.event.time_table
const tags = props.event.tags
const event = props.event
const organizers = props.event.organizers
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
        イベント詳細
      </h2>
    </template>
    <div class="pt-6 pb-8 lg:pb-16">
      <div class="flex lg:flex-row flex-col px-4 gap-4">
        <div class="lg:w-3/12 w-full mx-auto">
          <EventDatailLeftSide :time_table="time_table" class="sticky top-12" aria-labelledby="sidebar-left">
          </EventDatailLeftSide>
        </div>
        <div class="lg:w-6/12 w-full mx-auto">
          <EventDatailMain :created_at="event.created_at" :start_date="event.created_at" :end_date="event.created_at"
            :tags="tags" :title="event.title" :description="event.description" class="w-full">
          </EventDatailMain>
        </div>
        <div class="lg:w-3/12 w-full mx-auto">
          <EventDatailRightSide class="sticky top-12" :organizers="organizers" :trendTags="trendTags"
            aria-labelledby="sidebar-right" :recommendEvents="recommendEvents">
          </EventDatailRightSide>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<style lang="">

</style>
