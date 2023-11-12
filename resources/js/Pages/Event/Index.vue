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
  myLikeEvents: {
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
  router.get(route('event.list.index'), { section }, { replace: true, preserveState: true })
}
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
        イベントリスト
      </h2>
    </template>
    <div class="mx-auto mt-10 flex max-w-7xl flex-col gap-5">
      <CardShowMoreEvents section="highlight" title="注目" :events="props.highlightEvents">
      </CardShowMoreEvents>
      <CardShowMoreEvents section="new" title="新規" :events="props.newEvents">
      </CardShowMoreEvents>
      <CardShowMoreEvents section="ongoing" title="開催中" :events="props.ongoingEvents">
      </CardShowMoreEvents>
      <CardShowMoreEvents section="recent" title="直近" :events="props.recentEvents">
      </CardShowMoreEvents>
      <CardShowMoreEvents section="mylike" title="すき！" :events="props.myLikeEvents">
      </CardShowMoreEvents>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
