<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';

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
  myOrganizerEvents: {
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
      <!-- <EventListIndex title="プロモーション" :events="props.publicRelationsEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('pr')">show more!</BtnPrimary>
        </template>
      </EventListIndex> -->
      <EventListIndex title="注目" :events="props.highlightEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('highlight')">show more!</BtnPrimary>
        </template>
      </EventListIndex>
      <EventListIndex title="新規" :events="props.newEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('new')">show more!</BtnPrimary>
        </template>
      </EventListIndex>
      <EventListIndex title="開催中" :events="props.ongoingEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('ongoing')">show more!</BtnPrimary>
        </template>
      </EventListIndex>
      <EventListIndex title="直近" :events="props.recentEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('recent')">show more!</BtnPrimary>
        </template>
      </EventListIndex>
      <EventListIndex title="すき！" :events="props.myLikeEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('mylike')">show more!</BtnPrimary>
        </template>
      </EventListIndex>
      <EventListIndex title="主催" :events="props.myOrganizerEvents">
        <template #header>
          <BtnPrimary @click="getEvetnListSection('myorganizer')">show more!</BtnPrimary>
        </template>
      </EventListIndex>
    </div>
  </AppLayout>
</template>

<style lang="">

</style>
