<script setup lang="ts">
import { differenceInMinutes } from 'date-fns'
import type { TimeLineItem } from './EventTimeLineTypes'

const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
  startDate: {
    type: String,
    required: true,
  },
  endDate: {
    type: String,
    required: true,
  },
  columnWidthRem: {
    type: Number,
    required: true,
  },
})

const modalEventShare = ref(null)

//-----------------------------------------------
const EVENT_ITEM_MINUTE_SPAN = 15
const COLUMNS_PER_HOUR = Math.floor(60 / EVENT_ITEM_MINUTE_SPAN)

const startDate = computed(() => {
  return new Date(props.startDate)
})
const endDate = computed(() => {
  return new Date(props.endDate)
})
const hoursBetween = computed(() => {
  return differenceInMinutes(endDate.value, startDate.value) / EVENT_ITEM_MINUTE_SPAN + 1
})

/**
 * グリッドの位置を計算する
 */
const calculateGridPosition = (eventStartDate, eventEndDate) => {
  const baseStartDate = new Date(props.startDate)
  const eventStartDateTime = new Date(eventStartDate)
  const eventEndDateTime = new Date(eventEndDate)

  const startMinuteOffset = Math.floor(differenceInMinutes(eventStartDateTime, baseStartDate) / EVENT_ITEM_MINUTE_SPAN)
  const endMinuteOffset = Math.floor(differenceInMinutes(eventEndDateTime, baseStartDate) / EVENT_ITEM_MINUTE_SPAN) + 1

  const output = {
    start: startMinuteOffset + 1,
    span: endMinuteOffset - startMinuteOffset
  }
  return output
}

/**
 * タイムラインアイテムを計算する
 */
const timeLineItems = computed<TimeLineItem[]>(() => {
  return props.events.map((event:any) => {
    return {
      alias: event.alias,
      startDate: event.start_date,
      endDate: event.end_date,
      shortGoodCount: event.shortGoodCount,
      title: event.title,
      period: event.period,
      instances: event.instances,
      organizers: event.organizers,
      performers: event.performers,
      categoryNames: event.categoryNames,
      tags: event.tags,
      route: event.route,
      authUser: {
        isGood: 'isGood',
        isBookmark: 'isBookmark',
      },
      timeTable: event.time_table,
    }
  })
})

/**
 * グリッドのカラムスパンを取得する
 */
const getGridColumnSpan = (startDate, endDate) => {
  return `gridColumn: ${calculateGridPosition(startDate, endDate).start} / span ${calculateGridPosition(startDate, endDate).span}`
}

/**
 * イベントを共有する
 */
const shareEvent = (event) => {
  const targetEvent = props.events.find((e) => e.alias === event.alias)
  modalEventShare.value.onBtnOpenModal(targetEvent)
}
</script>

<template>
  <div class="h-full">
    <div
      :style="`grid-template-columns: repeat(${hoursBetween}, ${columnWidthRem}rem); grid-template-rows: repeat(auto-fill, 2rem);`"
      class="sticky top-0 z-20 grid w-fit select-none grid-flow-dense gap-1 rounded-md bg-base-300 px-1 pb-1">
      <TimeLineHeader :columns-per-hour="COLUMNS_PER_HOUR" :start-date="startDate" :end-date="endDate" />
    </div>

    <div
      :style="`grid-template-columns: repeat(${hoursBetween}, ${columnWidthRem}rem); grid-template-rows: repeat(auto-fill, 2rem);`"
      class="mt-1 grid h-full select-none  grid-flow-dense gap-1 px-1">
      <ModalEventShareConfirm ref="modalEventShare" />
      <TimeLineItem
        v-for="event in timeLineItems"
        :key="event" :style="getGridColumnSpan(event.startDate, event.endDate)" class="row-span-3"
        :time-line-item="event"
        @share="shareEvent(event)" />
    </div>
  </div>
</template>

<style>
</style>
