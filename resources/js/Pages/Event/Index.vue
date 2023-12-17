<script setup>

import file1 from '@/Components/Partials/LXIX_Design_224-4.png'
import file2 from '@/Components/Partials/LXIX_Design_225-5.png'
import file3 from '@/Components/Partials/LXIX_Design_196-4.png'

const image_flyers = [
  file1,
  file2,
  file3,
  file1,
  file2,
  file3,
  file1,
  file2,
  file3,
]
const props = defineProps({
  // publicRelationsEvents: {
  //   type: Array,
  //   required: true
  // },
  newEvents: {
    type: Array,
    required: true
  },
  highlightEvents: {
    type: Array,
    required: true
  },
  myBookmarkEvents: {
    type: Array,
    required: true
  },
  ongoingEvents: {
    type: Array,
    required: true
  },
  recentEvents: {
    type: Array,
    required: true
  },
})

const getEvetnListSection = (section) => {
  router.get(route('event.search.index'), { section }, { replace: true, preserveState: true })
}
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight ">
        イベント
      </h2>
    </template>
    <div class="mx-auto mt-2 flex max-w-7xl flex-col gap-2">
      <ShowMoreEvents section="highlight" title="注目" :events="props.highlightEvents">
      </ShowMoreEvents>
      <div class="divider"></div>
      <ShowMoreEvents section="new" title="新規" :events="props.newEvents">
      </ShowMoreEvents>
      <div class="divider"></div>
      <ShowMoreEvents section="ongoing" title="開催中" :events="props.ongoingEvents">
      </ShowMoreEvents>
      <div class="divider"></div>
      <ShowMoreEvents section="recent" title="直近" :events="props.recentEvents">
      </ShowMoreEvents>
      <div class="divider"></div>
      <ShowMoreEvents section="mybookmark" title="すき！" :events="props.myBookmarkEvents">
      </ShowMoreEvents>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
