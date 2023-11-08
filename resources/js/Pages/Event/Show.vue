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
const performers = props.event.performers
const tags = props.event.tags
const event = props.event
const trendTags = props.trendTags
const organizers = props.event.organizers.map(organizer => {
  return {
    name: organizer.event_organizeble.name,
    profile_url: organizer.event_organizeble_type == 'App\\Models\\Team'
      ? route('team.profile.show', organizer.event_organizeble.id)
      : route('user.profile.show', organizer.event_organizeble.id)
    ,
    image_url: organizer.event_organizeble.profile_photo_url ?? organizer.event_organizeble.team_logo_url,
    links: organizer.event_organizeble.links.map(link => {
      return {
        label: link.label,
        link: link.link
      }
    })
  }
});
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
        <div class="lg:w-4/12 w-full mx-auto">
          <EventDatailLeftSide :performers="performers" class="sticky top-12" aria-labelledby="sidebar-left">
          </EventDatailLeftSide>
        </div>
        <div class="lg:w-5/12 w-full mx-auto">
          <EventDatailMain :tags="tags" :event="event" class="w-full"></EventDatailMain>
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
