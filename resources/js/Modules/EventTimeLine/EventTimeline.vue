<script setup lang="ts">
import { differenceInMinutes } from 'date-fns'
import type { TimeLineItem } from './EventTimeLineTypes'

const props = defineProps({
  events: {
    type: Array,
    required: true,
  },
  startDate: {
    type: Date,
    required: true,
  },
  endDate: {
    type: Date,
    required: true,
  },
})

const isDragging = ref(false)
const startX = ref(0)
const startY = ref(0)
const scrollLeft = ref(0)
const scrollTop = ref(0)
const modalEventShare = ref(null)

const startDragging = (event) => {
  isDragging.value = true
  startX.value = event.pageX - event.currentTarget.offsetLeft
  startY.value = event.pageY - event.currentTarget.offsetTop
  scrollLeft.value = event.currentTarget.scrollLeft
  scrollTop.value = event.currentTarget.scrollTop
}

const stopDragging = () => {
  isDragging.value = false
}

const handleMouseMove = (event) => {
  if (!isDragging.value) return
  const x = event.pageX - event.currentTarget.offsetLeft
  const y = event.pageY - event.currentTarget.offsetTop
  const walkX = (x - startX.value) * 2 // 横スクロール速度を調整
  const walkY = (y - startY.value) * 2 // 縦スクロール速度を調整
  event.currentTarget.scrollLeft = scrollLeft.value - walkX
  event.currentTarget.scrollTop = scrollTop.value - walkY
}

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

const getGridColumnSpan = (startDate, endDate) => {
  return `gridColumn: ${calculateGridPosition(startDate, endDate).start} / span ${calculateGridPosition(startDate, endDate).span}`
}

const shareEvent = (event) => {
  const targetEvent = props.events.find((e) => e.alias === event.alias)
  modalEventShare.value.onBtnOpenModal(targetEvent)
}
</script>

<template>
  <div
    :style="`grid-template-columns: repeat(${hoursBetween},1rem);`"
    class="grid select-none grid-flow-dense gap-1 overflow-y-auto p-4 scrollbar-hide"
    @mousedown="startDragging"
    @mouseup="stopDragging"
    @mouseleave="stopDragging"
    @mousemove="handleMouseMove">
    <ModalEventShareConfirm ref="modalEventShare" mode="participant" />
    <TimeLineHeader :columns-per-hour="COLUMNS_PER_HOUR" :start-date="startDate" :end-date="endDate" />
    <TimeLineItem
      v-for="event in timeLineItems"
      :key="event" :style="getGridColumnSpan(event.startDate, event.endDate)"
      :time-line-item="event"
      @share="shareEvent(event)" />
  </div>
</template>

<style>
</style>
